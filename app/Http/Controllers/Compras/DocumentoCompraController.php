<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Compras\DetalleDocumentoCompra;
use App\Models\Compras\DocumentoCompra;
use App\Rules\RuleUniqueCompra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DocumentoCompraController extends Controller
{
    public function index()
    {
        return view('compras.documentoCompra.index');
    }
    public function getList()
    {
        $data = DocumentoCompra::where('estado', '!=','ANULADO')->with(['proveedor.persona.personaDni','proveedor.persona.personaRuc','almacen','tipoDocumento'])->get();
        return DataTables::of($data)->toJson();
    }
    public function create()
    {
        return view('compras.documentoCompra.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'proveedor_id' => ['required'],
                'almacen_id' => ['required'],
                'tipo_documento_id' => ['required'],
                'numeracion' => ['required', new RuleUniqueCompra($request->tipo_documento_id)],
                'fecha_emision' => ['required'],
                'fecha_entrega' => ['required'],
            ];
            $mensaje = [
                'proveedor_id.required' => "El Proveedor es requerido",
                'almacen_id.required' => "El almacen es requerido",
                'tipo_documento_id.required' => "El tipo de documento es requerido",
                'numeracion.required' => "La numeracion es requerida",
                'fecha_emision.required' => "La fecha de emision es requerida",
                'fecha_entrega.required' => "La fecha de entrega es requerida",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('errores', $validator->errors());
            }
            $docCompra = DocumentoCompra::create($request->except([
                'tabladetalle',
            ]));
            $total=0;
            $detalle = $request->get('tabladetalle');
            foreach (json_decode($detalle) as $key => $value) {
                $total += $value->total;
                DetalleDocumentoCompra::create([
                    "documento_compra_id" => $docCompra->id,
                    "insumo_id" => $value->insumo_id,
                    "cantidad" => $value->cantidad,
                    "precio" => $value->precio
                ]);
            }
            $docCompra->total=$total;
            $docCompra->save();

            DB::commit();
            return redirect()->route('documentoCompra.index');
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }
    public function edit($id)
    {
        $elemento = DocumentoCompra::where('id',$id)->with(['almacen', 'proveedor', 'detalle.insumo','tipoDocumento'])->first();
        return view('compras.documentoCompra.edit', compact('elemento'));
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $docCompra=DocumentoCompra::findOrFail($id);
            $rules = [
                'proveedor_id' => ['required'],
                'almacen_id' => ['required'],
                'tipo_documento_id' => ['required'],
                'numeracion' => ['required', new RuleUniqueCompra($request->tipo_documento_id,'update',$id)],
                'fecha_emision' => ['required'],
                'fecha_entrega' => ['required'],
            ];
            $mensaje = [
                'proveedor_id.required' => "El Proveedor es requerido",
                'almacen_id.required' => "El almacen es requerido",
                'tipo_documento_id.required' => "El tipo de documento es requerido",
                'numeracion.required' => "La numeracion es requerida",
                'fecha_emision.required' => "La fecha de emision es requerida",
                'fecha_entrega.required' => "La fecha de entrega es requerida",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('errores', $validator->errors());
            }
            $docCompra->update($request->except([
                'tabladetalle',
            ]));
            $total=0;
            foreach ($docCompra->detalle as $key => $value) {
                $insumo = $value->insumo;
                $insumo->stock -= $value->cantidad;
                $insumo->save();
            }
            DetalleDocumentoCompra::where('documento_compra_id',$id)->delete();

            $detalle = $request->get('tabladetalle');
            foreach (json_decode($detalle) as $key => $value) {
                $total += $value->total;
                DetalleDocumentoCompra::create([
                    "documento_compra_id" => $docCompra->id,
                    "insumo_id" => $value->insumo_id,
                    "cantidad" => $value->cantidad,
                    "precio" => $value->precio
                ]);
            }
            $docCompra->total=$total;
            $docCompra->save();

            DB::commit();
            return redirect()->route('documentoCompra.index');
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }
    public function destroy($id)
    {
        $dCompra = DocumentoCompra::findOrFail($id);
        foreach ($dCompra->detalle as $key => $fila) {
            $insumo = $fila->insumo;
            $insumo->stock -= $fila->cantidad;
            $insumo->save();
        }
        $dCompra->estado = 'ANULADO';
        $dCompra->save();
        return redirect()->route('documentoCompra.index');
    }
}
