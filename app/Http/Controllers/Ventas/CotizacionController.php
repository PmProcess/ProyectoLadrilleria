<?php

namespace App\Http\Controllers\Ventas;

use App\Models\Ventas\Cotizacion;
use App\Models\Ventas\DetalleCotizacion;
use App\Http\Controllers\Controller;
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

class CotizacionController extends Controller
{
    public function index()
    {
        return view("ventas.cotizacion.index");
    }
    public function getList()
    {
        $documentos = Cotizacion::where('estado', 'ACTIVO')->with(['cliente'])->get()->map(function ($documento) {
            $documento->cliente->persona->tipoPersona;
            return $documento;
        });
        return DataTables::of($documentos)->toJson();
    }
    public function create()
    {
        return view('ventas.cotizacion.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'cliente_id' => ['required'],
            ];
            $mensaje = [
                'cliente_id.required' => "El campo cliente es obligatorio",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->with('errores', $validator->errors())->withInput();
            }
            $total = 0;
            $datos = $request->except(['detalle']);
            $datos['user_id'] = Auth::user()->id;
            $datos['total'] = $total;
            $detalle = $request->get('tabladetalle');
            $documento = Cotizacion::create($datos);
            foreach (json_decode($detalle) as $value) {
                $total += $value->total;
                $producto=Producto::findOrFail($value->producto_id);
                $producto->stock-=$value->cantidad;
                $producto->save();
                DetalleCotizacion::create([
                    "cotizacion_id" => $documento->id,
                    "producto_id" => $value->producto_id,
                    "cantidad" => $value->cantidad,
                    "precio" => $value->precio
                ]);
            }
            $documento->total = $total;
            $documento->save();
            DB::commit();
            Session::flash('mensaje', "Registro con Exito");
            return redirect()->route('cotizacion.index');
        } catch (Exception $e) {
            DB::rollback();
            Log::info($e);
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }
    public function createDocumento($id)
    {
        $cotizacion =Cotizacion::where('id',$id)->with(['detalle'])->first();
        
    }
    public function storeDocumento(Request $request)
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
        $cotizacion = Cotizacion::findOrFail($id);
        return view('ventas.cotizacion.edit', $cotizacion);
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'cliente_id' => 'required',
            ];
            $mensaje = [
                'cliente_id.required' => "El campo cliente es obligatorio",
            ];
            Validator::make($request->all(), $rules, $mensaje)->validate();
            $datos = $request->except(['detalle']);
            $datos['user_id'] = Auth::user()->id;
            $documento = Cotizacion::findOrFail($id);
            $documento->update($datos);
            foreach ($request->detalle as $key => $value) {
                DetalleCotizacion::where('cotizacion_id', $documento->id)->update([
                    'estado' => 'ANULADO'
                ]);
                $detalle = DetalleCotizacion::where('producto_id', $value['producto_id'])->where('cotizacion_id', $documento->id)->first();
                if ($detalle) {
                    $detalle->cantidad = $value['cantidad'];
                    $detalle->precio = $value['precio'];
                    $detalle->estado = "ACTIVO";
                    $detalle->save();
                } else {
                    DetalleCotizacion::create([
                        "cotizacion_id" => $documento->id,
                        "producto_id" => $value['producto_id'],
                        "cantidad" => $value['cantidad'],
                        "precio" => $value['precio']
                    ]);
                }
            }
            foreach($documento->detalle as $item)
            {
                if($item->estado=="ANULADO")
                {
                    $item->delete();
                }
            }
            DB::commit();
            Session::flash('mensaje', "Registro con Exito");
            return redirect()->route('cotizacion.index');
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
            $documento=Cotizacion::findOrFail($id)->update([
                'estado' => "ANULADO"
            ]);
            DB::commit();
            Session::flash('mensaje', "Se Elimino con Exito");
            return redirect()->route('cotizacions.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}
