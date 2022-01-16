<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Cliente;
use App\Models\Configuracion\Numeracion;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoPago;
use App\Models\Mantenimiento\EmpresaPersonal;
use App\Models\Ventas\DetalleDocumentoVenta;
use App\Models\Ventas\DocumentoVenta;
use App\Models\Ventas\EnvioSunat;
use App\Models\Ventas\Pago;
use App\Models\Ventas\Producto;
use App\Rules\TipoDocumentoClienteRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use Luecano\NumeroALetras\NumeroALetras;

class DocumentoVentaController extends Controller
{
    public function index()
    {
        return view("ventas.documentoVenta.index");
    }
    public function getList()
    {
        $documentos = DocumentoVenta::where('estado', 'ACTIVO')->with(['cliente', 'empleado', 'correlativo', 'tipoDocumento', 'pagos.formaPago'])->get()->map(function ($documento) {
            $documento->cliente->persona->tipoPersona;
            $documento->correlativo->numeracion;
            return $documento;
        });
        return DataTables::of($documentos)->toJson();
    }
    public function create()
    {
        return view('ventas.documentoVenta.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'cliente_id' => ['required', new TipoDocumentoClienteRule($request->tipo_documento_id)],
                'tipo_documento_id' => 'required',
                'fecha_registro' => 'required',
                'fecha_vencimiento' => 'required',
            ];
            $mensaje = [
                'cliente_id.required' => "El campo cliente es obligatorio",
                'tipo_documento_id.required' => "El campo tipo documento es obligatorio",
                'fecha_registro.required' => "El campo fecha registro es obligatorio",
                'fecha_vencimiento.required' => "El campo fecha vencimiento es obligatorio",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->with('errores', $validator->errors())->withInput();
            }
            if (!TipoDocumento::findOrFail($request->tipo_documento_id)->numeracionSeleccionada) {
                Session::flash("error", "No se ha seleccionado una serie para este tipo de Documento");
                return redirect()->back()->withInput();
            }
            $total = 0;
            $datos = $request->except(['detalle']);
            $datos['correlativo_id'] = obtenerCorrelativo(TipoDocumento::findOrFail($request->tipo_documento_id))->id;
            $datos['user_id'] = Auth::user()->id;
            $datos['total'] = $total;
            $datos['deuda'] = $total;
            $datos['tipo_pago_id'] = 1;
            $detalle = $request->get('tabladetalle');
            $documento = DocumentoVenta::create($datos);
            foreach (json_decode($detalle) as $value) {
                $total += $value->total;
                $producto=Producto::findOrFail($value->producto_id);
                $producto->stock-=$value->cantidad;
                $producto->save();
                DetalleDocumentoVenta::create([
                    "documento_venta_id" => $documento->id,
                    "producto_id" => $value->producto_id,
                    "cantidad" => $value->cantidad,
                    "precio" => $value->precio
                ]);
            }
            $documento->total = $total;
            $documento->deuda = $total;
            $documento->save();
            DB::commit();
            Session::flash('mensaje', "Registro con Exito");
            return redirect()->route('documentoVenta.index');
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function edit($id)
    {
        $documentoVenta = DocumentoVenta::findOrFail($id);
        return view('ventas.documentoVenta.edit', $documentoVenta);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'cliente_id' => 'required',
                'tipo_pago_id' => 'required',
                'tipo_documento_id' => 'required',
                'fecha_registro' => 'required',
                'fecha_vencimiento' => 'required',
                'moneda' => 'required',
                'total' => 'total'
            ];
            $mensaje = [
                'cliente_id.required' => "El campo cliente es obligatorio",
                'tipo_pago_id.required' => "El campo tipo pago es obligatorio",
                'tipo_documento_id.required' => "El campo tipo documento es obligatorio",
                'fecha_registro.required' => "El campo fecha registro es obligatorio",
                'fecha_vencimiento.require' => "El campo fecha vencimiento es obligatorio",
                'moneda.required' => "El campo moneda es obligatorio",
                'total.required' => "El campo total es obligatorio"
            ];
            Validator::make($request->all(), $rules, $mensaje)->validate();
            $datos = $request->except(['detalle']);
            $datos['user_id'] = Auth::user()->id;
            $documento = DocumentoVenta::findOrFail();
            $documento->update($datos);
            foreach ($request->detalle as $key => $value) {
                DetalleDocumentoVenta::where('documento_venta_id', $documento->id)->update([
                    'estado' => 'ANULADO'
                ]);
                $detalle = DetalleDocumentoVenta::where('producto_id', $value['producto_id'])->where('documento_venta_id', $documento->id)->first();
                if ($detalle) {
                    $detalle->cantidad = $value['cantidad'];
                    $detalle->precio = $value['precio'];
                    $detalle->estado = "ACTIVO";
                    $detalle->save();
                } else {
                    DetalleDocumentoVenta::create([
                        "documento_venta_id" => $documento->id,
                        "producto_id" => $value['producto_id'],
                        "cantidad" => $value['cantidad'],
                        "precio" => $value['precio']
                    ]);
                }
            }
            DB::commit();
            Session::flash('mensaje', "Registro con Exito");
            return redirect()->route('documentoVenta.index');
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $documento=DocumentoVenta::findOrFail($id)->update([
                'estado' => "ANULADO"
            ]);
            foreach ($documento->detalle as $key => $value) {
                $producto=$value->producto;
                $producto->stock+=$value->cantidad;
                $producto->save();
            }
            DB::commit();
            Session::flash('mensaje', "Se Elimino con Exito");
            return redirect()->route('documentoVentas.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
    public function storePago(Request $request)
    {
        DB::beginTransaction();
        try {
            $pago = Pago::create($request->except(['imagen']));
            if ($request->hasFile('imagen')) {
                $pago->url_imagen = $request->file('imagen')->store('public/pagos');
                $pago->nombre_imagen = $request->file('imagen')->getClientOriginalName();
            }
            $pago->save();
            $documento = DocumentoVenta::findOrFail($request->documento_venta_id);
            $documento->deuda = $documento->deuda - ($pago->efectivo + $pago->transferencia);
            $documento->save();
            if ($documento->deuda == 0) {
                $documento->estado_documento = 'PAGADO';
                $documento->save();
            }
            DB::commit();
            $pago->formaPago;
            return response()->json([
                'success' => true,
                'mensaje' => 'Registro con Exito',
                'data' => $pago,
                "montoDeuda" => $documento->deuda
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e);
            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
    public function download($id)
    {
        $pago = Pago::findOrFail($id);
        return Storage::download($pago->url_imagen);
    }
    public function ticket($id)
    {
        try {
            $file = database_path("data/TipoDocumento/tipodocumento.json");
            $json = file_get_contents($file);
            $data = json_decode($json);
            $empresa = EmpresaPersonal::findOrFail(1);
            $documento = DocumentoVenta::findOrFail($id);
            if ($documento->tipoDocumento->tipo == "Boleta de Venta") {
                $opcion = $data[0]->Boleta;
            } elseif ($documento->tipoDocumento->tipo == "Factura de Venta") {
                $opcion = $data[0]->Factura;
            }
            $qr = self::qr_code($documento, $empresa);
            $legends = self::obtenerLeyenda($documento);
            if (!$qr['success']) {
                Session::flash('error', $qr['mensaje']);
                return redirect()->back();
            }
            $pdf = PDF::loadView('ventas.documentoVenta.reportes.ticket', compact('documento', 'opcion', 'empresa', 'legends'))->setPaper([0, 0, 226.772, 651.95]);
            return $pdf->stream();
        } catch (Exception $e) {
            Log::info($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function a4($id)
    {
        try {
            $file = database_path("data/TipoDocumento/tipodocumento.json");
            $json = file_get_contents($file);
            $data = json_decode($json);
            $empresa = EmpresaPersonal::findOrFail(1);
            $documento = DocumentoVenta::findOrFail($id);
            if ($documento->tipoDocumento->tipo == "Boleta de Venta") {
                $opcion = $data[0]->Boleta;
            } elseif ($documento->tipoDocumento->tipo == "Factura de Venta") {
                $opcion = $data[0]->Factura;
            }
            $qr = self::qr_code($documento, $empresa);
            $legends = self::obtenerLeyenda($documento);
            if (!$qr['success']) {
                Session::flash('error', $qr['mensaje']);
                return redirect()->back();
            }
            $pdf = PDF::loadView('ventas.documentoVenta.reportes.a4', compact('documento', 'opcion', 'empresa', 'legends'));
            return $pdf->stream();
        } catch (Exception $e) {
            Log::info($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    /**
     *@param \App\Models\Ventas\DocumentoVenta $documento El Documento de Venta
     *@param \App\Models\Mantenimiento\EmpresaPersonal $empresa La Empresa Personal
     */
    public static function qr_code($documento, $empresa)
    {
        try {
            if ($documento->url_qr == null) {
                $arreglo_qr = array(
                    "ruc" => $empresa->ruc,
                    "tipo" => $documento->cliente->persona->personaDni ? '03' : '01',
                    "serie" => $documento->correlativo->numeracion->serie,
                    "numero" => $documento->correlativo->correlativo,
                    "emision" => self::obtenerFechaEmision($documento),
                    "igv" => 18,
                    "total" => (float)$documento->total,
                    "clienteTipo" => $documento->cliente->persona->personaDni ? 1 : 6,
                    "clienteNumero" => $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->dni : $documento->cliente->persona->personaRuc->ruc
                );
                /********************************/
                $data_qr = generarQrApi(json_encode($arreglo_qr));
                $name_qr =  $documento->correlativo->numeracion->serie . "-" . $documento->correlativo->correlativo . '.svg';
                $pathToFile_qr = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs' . DIRECTORY_SEPARATOR . $name_qr);
                if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs'))) {
                    mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs'));
                }
                file_put_contents($pathToFile_qr, $data_qr);
                $documento->url_qr = 'public/qrs/' . $name_qr;
                $documento->save();
                return array('success' => true, 'mensaje' => 'QR creado exitosamente');
            } else {
                return array('success' => true, 'mensaje' => 'QR creado exitosamente');
            }
        } catch (Exception $e) {
            Log::info($e);
            return array('success' => false, 'mensaje' => $e->getMessage());
        }
    }
    public static function obtenerFechaEmision($documento)
    {
        $date = strtotime($documento->fecha_registro);
        $fecha_emision = date('Y-m-d', $date);
        $hora_emision = date('H:i:s', $date);
        $fecha = $fecha_emision . 'T' . $hora_emision . '-05:00';
        return $fecha;
    }
    public static function obtenerLeyenda($documento)
    {
        $formatter = new NumeroALetras();
        $convertir = $formatter->toInvoice($documento->total, 2, 'SOLES');
        //CREAR LEYENDA DEL COMPROBANTE
        $arrayLeyenda = array();
        $arrayLeyenda[] = array(
            "code" => "1000",
            "value" => $convertir
        );
        return $arrayLeyenda;
    }
    public function sunat($id)
    {

            $documento = DocumentoVenta::findorfail($id);
            $empresa = EmpresaPersonal::first();
            if (EnvioSunat::where('documento_venta_id',$id)->where('estado','ACEPTADO')->count()==0) {
                //ARREGLO COMPROBANTE
                $arreglo_comprobante = array(
                    "tipoOperacion" => "0101",
                    "tipoDoc" => $documento->cliente->persona->personaDni ? "03" : "01",
                    "serie" => $documento->correlativo->numeracion->serie,
                    "correlativo" =>  $documento->correlativo->correlativo,
                    "fechaEmision" => self::obtenerFechaEmision($documento),
                    "formaPago" => array(
                        "moneda" => "PEN",
                        "tipo" => "Contado"
                    ),
                    "tipoMoneda" => "PEN",
                    "client" => array(
                        "tipoDoc" => $documento->cliente->persona->personaDni ? 1 : 6,
                        "numDoc" => $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->dni : $documento->cliente->persona->personaRuc->ruc,
                        "rznSocial" => $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->nombres_apellidos() : $documento->cliente->persona->personaRuc->nombre_comercial,
                        // "address" => array(
                        //     "direccion" => $documento->direccion_cliente,
                        // )
                    ),
                    "company" => array(
                        "ruc" =>  $empresa->ruc,
                        "razonSocial" => $empresa->nombre_comercial,
                        "address" => array(
                            "direccion" => $empresa->direccion,
                        )
                    ),
                    "mtoOperGravadas" => (float)number_format($documento->total / (1 + 0.18), 2),
                    "mtoOperExoneradas" => 0,
                    "mtoIGV" => (float) number_format($documento->total - ($documento->total / (1 + 0.18)), 2),
                    "valorVenta" => (float)number_format($documento->total / (1 + 0.18), 2),
                    "totalImpuestos" => (float)number_format($documento->total - ($documento->total / (1 + 0.18)), 2),
                    "subTotal" => (float)number_format($documento->total, 2),
                    "mtoImpVenta" => (float)number_format($documento->total, 2),
                    "ublVersion" => "2.1",
                    "details" => self::obtenerProductos($documento),
                    "legends" =>  self::obtenerLeyenda($documento),
                );

                //OBTENER JSON DEL COMPROBANTE EL CUAL SE ENVIARA A SUNAT

                $data = enviarComprobanteapi(json_encode($arreglo_comprobante));
                // Log::info($arreglo_comprobante);
                // Log::info($data);
                //RESPUESTA DE LA SUNAT EN JSON
                $json_sunat = json_decode($data);
                $envioSunat = new EnvioSunat();
                $envioSunat->documento_venta_id=$id;
                if ($json_sunat->sunatResponse->success == true) {
                    $documento->estado_documento = 'EXITO';

                    $respuesta_cdr = json_encode($json_sunat->sunatResponse->cdrResponse, true);
                    // $respuesta_cdr = json_decode($respuesta_cdr,true);
                    $envioSunat->cdr_response = $respuesta_cdr;
                    $envioSunat->save();

                    $data_comprobante = generarComprobanteapi(json_encode($arreglo_comprobante));
                    $name = $documento->correlativo->numeracion->serie . "-" .  $documento->correlativo->correlativo . '.pdf';
                    $data_cdr = base64_decode($json_sunat->sunatResponse->cdrZip);
                    $name_cdr = 'R-' . $documento->correlativo->numeracion->serie . "-" .  $documento->correlativo->correlativo . '.zip';
                    if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'sunat'))) {
                        mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'sunat'));
                    }
                    if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cdr'))) {
                        mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cdr'));
                    }
                    $pathToFile = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'sunat' . DIRECTORY_SEPARATOR . $name);
                    $pathToFile_cdr = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'cdr' . DIRECTORY_SEPARATOR . $name_cdr);
                    file_put_contents($pathToFile, $data_comprobante);
                    file_put_contents($pathToFile_cdr, $data_cdr);
                    $arreglo_qr = array(
                        "ruc" => $empresa->ruc,
                        "tipo" => $documento->cliente->persona->personaDni ? '03' : '01',
                        "serie" => $documento->correlativo->numeracion->serie,
                        "numero" => $documento->correlativo->correlativo,
                        "emision" => self::obtenerFechaEmision($documento),
                        "igv" => 18,
                        "total" => (float)$documento->total,
                        "clienteTipo" => $documento->cliente->persona->personaDni ? 1 : 6,
                        "clienteNumero" => $documento->cliente->persona->personaDni ? $documento->cliente->persona->personaDni->dni : $documento->cliente->persona->personaRuc->ruc
                    );
                    /********************************/
                    $data_qr = generarQrApi(json_encode($arreglo_qr));
                    $name_qr = $documento->correlativo->numeracion->serie . "-" .  $documento->correlativo->correlativo . '.svg';
                    $pathToFile_qr = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs' . DIRECTORY_SEPARATOR . $name_qr);
                    if (!file_exists(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs'))) {
                        mkdir(storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'qrs'));
                    }
                    file_put_contents($pathToFile_qr, $data_qr);
                    /********************************/
                    /********************************* */
                    $documento->nombre_comprobante_archivo = $name;
                    $documento->url_comprobante_archivo = 'public/sunat/' . $name;
                    $documento->url_qr = 'public/qrs/' . $name_qr;
                    $documento->hash = $json_sunat->hash;
                    $documento->estado_documento = 'EXITO';
                    $documento->update();


                    $envioSunat->estado = 'ACEPTADO';
                    $envioSunat->save();
                    DB::commit();
                    //Registro de actividad
                    Session::flash('mensaje', 'Documento de Venta enviada a Sunat con exito.');
                    return redirect()->route('documentoVenta.index');
                } else {
                    //COMO SUNAT NO LO ADMITE VUELVE A SER 0
                    $documento->estado_documento = 'FALLO';
                    $documento->update();
                    if ($json_sunat->sunatResponse->error) {
                        $envioSunat->codigo = $json_sunat->sunatResponse->error->code;
                        $envioSunat->message_response = $json_sunat->sunatResponse->error->message;
                    } else {
                        $envioSunat->id_response = $json_sunat->sunatResponse->cdrResponse->id;
                        $envioSunat->descripcion = $json_sunat->sunatResponse->cdrResponse->description;
                    };
                    $envioSunat->estado = "RECHAZADO";
                    $envioSunat->save();
                    $documento->estado_documento = 'FALLO';
                    $documento->update();
                    DB::commit();
                    Session::flash('error', 'Documento de Venta sin exito en el envio a sunat.');
                    return redirect()->route('documentoVenta.index');
                }
            }
            $documento->estado_documento = 'EXITO';
            $documento->update();
            Session::flash('mensaje', 'Documento de venta fue enviado a Sunat.');
            return redirect()->route('documentoVenta.index');

    }
    public static function obtenerProductos($documento)
    {

        foreach ($documento->detalle as $key => $value) {
            $arrayProductos[] = array(
                "codProducto" => $value->producto->codigo,
                "unidad" => $value->producto->unidadMedida->simbolo,
                "descripcion" => $value->producto->nombre,
                "cantidad" =>  (float)sprintf("%.2f", (float)$value->cantidad),
                "mtoValorUnitario" => (float) sprintf("%.2f", (float)($value->producto->precio_venta / 1.18)),
                "mtoValorVenta" => (float)sprintf("%.2f", (float)(($value->producto->precio_venta * $value->cantidad) / 1.18)),
                "mtoBaseIgv" => (float)sprintf("%.2f", (float)(($value->producto->precio_venta * $value->cantidad) / 1.18)),
                "porcentajeIgv" => 18,
                "igv" => (float) sprintf("%.2f", (float)(($value->producto->precio_venta * $value->cantidad)  - ($value->producto->precio_venta * $value->cantidad) / 1.18)),
                "tipAfeIgv" => 10,
                "totalImpuestos" => (float) sprintf("%.2f", (float)($value->producto->precio_venta * $value->cantidad)  - (($value->producto->precio_venta * $value->cantidad) / 1.18)),
                "mtoPrecioUnitario" => (float)sprintf("%.2f", (float)$value->producto->precio_venta)
            );
        }

        return $arrayProductos;
    }
}
