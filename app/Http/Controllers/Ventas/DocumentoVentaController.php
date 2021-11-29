<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Administracion\Cliente;
use App\Models\Configuracion\Numeracion;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoPago;
use App\Models\Ventas\DetalleDocumentoVenta;
use App\Models\Ventas\DocumentoVenta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DocumentoVentaController extends Controller
{
    public function index()
    {
        return view("ventas.documentoVenta.index");
    }
    public function getList()
    {
        $documentos = DocumentoVenta::where('estado', 'ACTIVO')->with(['cliente', 'empleado', 'tipoPago', 'correlativo', 'tipoDocumento'])->get()->map(function ($documento) {
            $documento->cliente->persona->tipoPersona;
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
            if (!TipoDocumento::findOrFail($request->tipo_documento_id)->numeracionSeleccionada) {
                Session::flash("error", "No se ha seleccionado una serie para este tipo de Documento");
                return redirect()->back();
            }

            $datos = $request->except(['detalle']);
            $datos['correlativo_id'] = obtenerCorrelativo(TipoDocumento::findOrFail($request->tipo_documento_id))->id;
            $datos['user_id'] = Auth::user()->id;
            $documento = DocumentoVenta::create($datos);
            foreach ($request->detalle as $key => $value) {
                DetalleDocumentoVenta::create([
                    "documento_venta_id" => $documento->id,
                    "producto_id" => $value['producto_id'],
                    "cantidad" => $value['cantidad'],
                    "precio" => $value['precio']
                ]);
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
            DocumentoVenta::findOrFail($id)->update([
                'estado' => "ANULADO"
            ]);
            DB::commit();
            Session::flash('mensaje', "Se Elimino con Exito");
            return redirect()->route('documentoVentas.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}
