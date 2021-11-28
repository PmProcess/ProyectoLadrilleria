<?php

use App\Models\Administracion\Cliente;
use App\Models\Configuracion\NumeracionConteo;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoPago;
use App\Models\Ubigeo\Departamento;
use App\Models\Ubigeo\Distrito;
use App\Models\Ubigeo\Provincia;

if (!function_exists('getDepartamentos')) {
    function getDepartamentos()
    {
        return Departamento::get();
    }
}
if (!function_exists('getProvincias')) {
    function getProvincias()
    {
        return Provincia::get();
    }
}
if (!function_exists('getDistritos')) {
    function getDistritos()
    {
        return Distrito::get();
    }
}
if (!function_exists('getClientes')) {
    function getClientes()
    {
        return Cliente::where('estado', 'ACTIVO')->get();
    }
}
if (!function_exists('getTipoPagos')) {
    function getTipoPagos()
    {
        return TipoPago::get();
    }
}
if(!function_exists('getTipoDocumentos'))
{
    function getTipoDocumentos()
    {
        return TipoDocumento::with(['numeracionSeleccionada'])->get();
    }
}
if (!function_exists('obtenerCorrelativo')) {
    /**
     * @param \App\Models\Configuracion\TipoDocumento $tipoDocumento El tipo de Documento en modelo
     * @return \App\Models\Configuracion\NumeracionConteo
     */
    function obtenerCorrelativo($tipoDocumento)
    {
        $numeracion = $tipoDocumento->numeracionSeleccionada;
        if ($numeracion->conteo()->count() == 0) {
            return NumeracionConteo::create([
                'numeracion' => $numeracion->id,
                'correlativo' => $numeracion->correlativo_iniciar
            ]);
        }

        return NumeracionConteo::create(['numeracion' => $numeracion->id, 'correlativo' => $numeracion->conteo()->orderBy('created_at desc')->first()->correlativo + 1]);
    }
}
