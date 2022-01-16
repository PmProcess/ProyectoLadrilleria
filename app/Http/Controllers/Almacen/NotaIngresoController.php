<?php
namespace App\Http\Controllers\Almacen;
use App\Http\Controllers\Controller;
use App\Models\Almacen\DetalleNotaIngreso;
use App\Models\Almacen\NotaIngreso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
class NotaIngresoController extends Controller
{
    public function index()
    {
        return view('almacen.nota.index');
    }
    public function getList()
    {
        $data = NotaIngreso::where('estado', 'ACTIVO')->with(['almacen'])->get();
        return DataTables::of($data)->toJson();
    }
    public function create()
    {
        return view('almacen.nota.create');
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'almacen_id' => ['required'],
                'fecha_emision' => ['required'],
            ];
            $mensaje = [
                'almacen_id.required' => "El almacen es requerido",
                'fecha_emision.required' => "La fecha de emision es requerida",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('errores', $validator->errors());
            }
            $r_nota=$request->except([
                'tabladetalle',
            ]);
            $r_nota['user_id']=Auth::user()->id;
            $notaIngreso = NotaIngreso::create($r_nota);
            $detalle = $request->get('tabladetalle');
            foreach (json_decode($detalle) as $key => $value) {
                DetalleNotaIngreso::create([
                    "nota_ingreso_id" => $notaIngreso->id,
                    "producto_id" => $value->producto_id,
                    "cantidad" => $value->cantidad,
                    "fecha_vencimiento" => $value->fecha_vencimiento
                ]);
            }
            DB::commit();
            return redirect()->route('notaIngreso.index');
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }
    public function edit($id)
    {
        $elemento=NotaIngreso::where('id',$id)->with(['almacen','detalle.producto'])->first();
        return view('almacen.nota.edit',compact('elemento'));
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $notaIngreso = NotaIngreso::findOrFail($id);
            $notaIngreso->user_id=Auth::user()->id;
            $rules = [
                'almacen_id' => ['required'],
                'fecha_emision' => ['required'],
            ];
            $mensaje = [
                'almacen_id.required' => "El almacen es requerido",
                'fecha_emision.required' => "La fecha de emision es requerida",
            ];
            $validator = Validator::make($request->all(), $rules, $mensaje);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('errores', $validator->errors());
            }
            $notaIngreso->update($request->except([
                'tabladetalle',
            ]));
            foreach ($notaIngreso->detalle as $key => $value) {
                $producto = $value->producto;
                $producto->stock -= $value->cantidad;
                $producto->save();
            }
            DetalleNotaIngreso::where('nota_ingreso_id', $id)->delete();
            $detalle = $request->get('tabladetalle');
            foreach (json_decode($detalle) as $key => $value) {
                DetalleNotaIngreso::create([
                    "nota_ingreso_id" => $notaIngreso->id,
                    "producto_id" => $value->producto_id,
                    "cantidad" => $value->cantidad,
                    "fecha_vencimiento" => $value->fecha_vencimiento
                ]);
            }
            $notaIngreso->save();
            DB::commit();
            return redirect()->route('notaIngreso.index');
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->back()->withInput();
        }
    }
    public function destroy($id)
    {
        $notaIngreso = NotaIngreso::findOrFail($id);
        foreach ($notaIngreso->detalle as $key => $fila) {
            $producto = $fila->producto;
            $producto->stock -= $fila->cantidad;
            $producto->save();
        }
        $notaIngreso->estado = 'ANULADO';
        $notaIngreso->save();
        return redirect()->route('notaIngreso.index');
    }
}
