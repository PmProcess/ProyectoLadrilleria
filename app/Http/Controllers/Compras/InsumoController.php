<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\Compras\Insumo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InsumoController extends Controller
{
    public function index()
    {
        return view('compras.insumo.index');
    }
    public function getList()
    {
        return Insumo::where('estado', 'ACTIVO')->with(['unidadMedida'])->get();
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = $request->except(['imagen']);
            if ($request->hasFile('imagen')) {
                $datos['url_imagen'] = $request->file('imagen')->store('public/Insumo');
                $datos['nombre_imagen'] = $request->file('imagen')->getClientOriginalName();
            }
            Insumo::create($datos);
            DB::commit();
            return array("success" => true, "mensaje" => "Registro con Exito");
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e);
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $datos = $request->except(['imagen']);
            if ($request->hasFile('imagen')) {
                $datos['url_imagen'] = $request->file('imagen')->store('public/Insumo');
                $datos['nombre_imagen'] = $request->file('imagen')->getClientOriginalName();
            }
            Insumo::findOrFail($id)->update(
                $datos
            );
            DB::commit();
            return array("success" => true, "mensaje" => "Actualizado con Exito");
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e);
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Insumo::findOrFail($id)->update([
                "estado" => "ANULADO"
            ]);
            DB::commit();
            return array("success" => true, "mensaje" => "Eliminado con Exito");
        } catch (Exception $e) {
            DB::rollBack();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
}
