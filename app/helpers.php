<?php

use App\Models\Administracion\Cliente;
use App\Models\Configuracion\NumeracionConteo;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoMoneda;
use App\Models\Configuracion\TipoPago;
use App\Models\Ubigeo\Departamento;
use App\Models\Ubigeo\Distrito;
use App\Models\Ubigeo\Provincia;
use App\Models\Ventas\Producto;
use Illuminate\Support\Facades\Log;

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
        return Cliente::with(['persona'])->get()->filter(function ($cliente) {

            return $cliente->persona->estado == "ACTIVO";
        })->map(function ($cliente) {

            $cliente->nombre_completo = $cliente->persona->tipoPersona->nombre_completo;
            return $cliente;
        });
    }
}
if (!function_exists('getTipoPagos')) {
    function getTipoPagos()
    {
        return TipoPago::get()->map(function ($tipopago) {
            $tipopago->tipo_completo = $tipopago->tipo . " - " . $tipopago->dias;
            return $tipopago;
        });
    }
}
if (!function_exists('getTipoDocumentos')) {
    function getTipoDocumentos()
    {
        return TipoDocumento::get()->filter(function ($tipoDocumento) {
            return $tipoDocumento->id == 1 || $tipoDocumento->id == 2;
        });
    }
}
if (!function_exists('getTipoMoneda')) {
    function getTipoMoneda()
    {
        return TipoMoneda::where('estado', 'ACTIVO')->get();
    }
};
if (!function_exists('getProductos')) {
    /**
     * @param $tipoOperacion Indica el tipo de operacion de un producto ,puede ser compra o venta o ambas
     */
    function getProductos($tipoOperacion)
    {
        if ($tipoOperacion == "VENTA") {

            return Producto::where('tipo_operacion', "!=", 'COMPRA')->get();
        }

        return Producto::where('tipo_operacion', "!=", 'VENTA')->get();
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
                'numeracion_id' => $numeracion->id,
                'correlativo' => $numeracion->correlativo_iniciar
            ]);
        }

        return NumeracionConteo::create(['numeracion_id' => $numeracion->id, 'correlativo' => $numeracion->conteo()->orderBy('created_at','desc')->first()->correlativo + 1]);
    }
}
