<?php

namespace App\Http\Controllers\Configuracion;

use App\Http\Controllers\Controller;
use App\Models\Configuracion\Numeracion;
use App\Models\Configuracion\TipoDocumento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class NumeracionController extends Controller
{
    public function index()
    {
        return view('configuracion.numeracion.index');
    }
    public function getList()
    {
        $numeracion = Numeracion::where('estado', 'ACTIVO')->with(['tipoDocumento'])->get();
        return DataTables::of($numeracion)->toJson();
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $datos = $request->all();
            $tipoDocumento = TipoDocumento::findOrFail($datos['tipo_documento_id']);
            if ($tipoDocumento->tipo == "Boleta de Venta") {
                if (!str_contains($datos['serie'], "B")) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "La serie de una Boleta debe iniciar con la letra B ");
                }
            } elseif ($tipoDocumento->tipo == "Factura de Venta") {
                if (!str_contains($datos['serie'], "F")) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "La serie de una Factura debe iniciar con la letra F ");
                }
            }
            if (!Numeracion::where('serie', $datos['serie'])->where('correlativo_iniciar', $datos['correlativo_iniciar'])->first()) {
                $numeracion = Numeracion::where('serie', $datos['serie'])->first();
                if ($numeracion  && $numeracion->conteo()->where('correlativo', $datos['correlativo_iniciar'])->first()) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "el correlativo ya esta en uso");
                } else {
                    Numeracion::create($datos);
                    DB::commit();
                    return array("success" => true, "mensaje" => "Registro con exito");
                }
            } else {
                DB::rollback();
                return array("success" => false, "mensaje" => "La serie y el correlativo ya estan agregado");
            }
        } catch (Exception $e) {
            DB::rollback();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $numeracion = Numeracion::findOrFail($id);
            if ($numeracion->seleccionado == "SI") {
                return array("success" => false, "mensaje" => "No se puede Editar por que esta en Uso");
            }
            $datos = $request->all();
            if (
                $numeracion->serie == $datos['serie'] &&
                $numeracion->correlativo_iniciar == $datos['correlativo_iniciar'] &&
                $numeracion->tipo_documento_id == $datos['tipo_documento_id']
            ) {
                return array("success" => true, "mensaje" => "Registro con exito");
            }
            $tipoDocumento = $numeracion->tipoDocumento;
            if ($tipoDocumento->tipo == "Boleta de Venta") {
                if (!str_contains($datos['serie'], "B")) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "La serie de una Boleta debe iniciar con la letra B ");
                }
            } elseif ($tipoDocumento->tipo == "Factura de Venta") {
                if (!str_contains($datos['serie'], "F")) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "La serie de una Factura debe iniciar con la letra F ");
                }
            }
            if (!Numeracion::where('serie', $datos['serie'])->where('correlativo_iniciar', $datos['correlativo_iniciar'])->where('id', '!=', $id)->first()) {
                $numeracionUpdate = Numeracion::where('serie', $datos['serie'])->where('id', '!=', $id)->first();
                if ($numeracionUpdate  && $numeracionUpdate->conteo()->where('correlativo', $datos['correlativo_iniciar'])->first()) {
                    DB::rollback();
                    return array("success" => false, "mensaje" => "el correlativo ya esta en uso");
                } else {
                    $numeracion->update($datos);
                    DB::commit();
                    return array("success" => true, "mensaje" => "Registro con exito");
                }
            } else {
                DB::rollback();
                return array("success" => false, "mensaje" => "La serie y el correlativo ya estan agregado");
            }
        } catch (Exception $e) {
            DB::rollback();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function seleccionar($id)
    {
        DB::beginTransaction();
        try {
            $numeracion = Numeracion::findOrFail($id);
            $numeracion->seleccionado = "SI";
            $numeracion->save();
            $numeracion->tipoDocumento->numeraciones()->get()->map(function ($valor) use ($numeracion) {
                if ($numeracion->id != $valor->id) {
                    $valor->seleccionado = "NO";
                    $valor->save();
                }
            });
            DB::commit();
            return array("success" => true, "mensaje" => "Se Selecciono con Exito");
        } catch (Exception $e) {
            DB::rollback();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function deseleccionar($id)
    {
        try {
            $numeracion = Numeracion::findOrFail($id);
            $numeracion->seleccionado = "NO";
            $numeracion->save();
            DB::commit();
            return array("success" => true, "mensaje" => "Se deselecciono con Exito");
        } catch (Exception $e) {
            DB::rollback();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $numeracion = Numeracion::findOrFail($id);
            if ($numeracion->seleccionado == "SI") {
                return array("success" => false, "mensaje" => "No puede eliminar una numeracion que esta seleccionado");
            } else {
                if ($numeracion->conteo()->count() > 0) {
                    return array("success" => false, "mensaje" => "No puede eliminar esta numeracion por que ya se usó");
                } else {
                    $numeracion->estado = "ANULADO";
                    $numeracion->save();
                    DB::commit();
                    return array("success" => true , "mensaje" => "Se Elimino con Exito");
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return array("success" => false, "mensaje" => $e->getMessage());
        }
    }
}
