<?php

use App\Models\Administracion\Cliente;
use App\Models\Administracion\Proveedor;
use App\Models\Apis;
use App\Models\Compras\Insumo;
use App\Models\Configuracion\NumeracionConteo;
use App\Models\Configuracion\TipoDocumento;
use App\Models\Configuracion\TipoMoneda;
use App\Models\Configuracion\TipoPago;
use App\Models\FormaPago;
use App\Models\Mantenimiento\Almacen;
use App\Models\Mantenimiento\EmpresaPersonal;
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
if (!function_exists('getFormaPagos')) {
    function getFormaPagos()
    {
        return FormaPago::get();
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
    function getProductos()
    {
        //     if ($tipoOperacion == "VENTA") {

        //         return Producto::where('tipo_operacion', "!=", 'COMPRA')->get();
        //     }

        return Producto::where('estado', 'ACTIVO')->get();
    }
}
if (!function_exists('formasPagos')) {
    function formasPagos()
    {
        return FormaPago::get();
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

        return NumeracionConteo::create(['numeracion_id' => $numeracion->id, 'correlativo' => $numeracion->conteo()->orderBy('created_at', 'desc')->first()->correlativo + 1]);
    }
}
if(!function_exists('getProveedores'))
{
    function getProveedores(){
        return Proveedor::with(['persona'])->get()->filter(function ($persona) {

            return $persona->persona->estado == "ACTIVO";
        })->map(function ($persona) {

            $persona->nombre_completo = $persona->persona->tipoPersona->nombre_completo;
            return $persona;
        });

    }
}
if(!function_exists('getAlmacenes'))
{
    function getAlmacenes()
    {
        return Almacen::where('estado','ACTIVO')->get();
    }
}
if(!function_exists('getInsumos'))
{
    function getInsumos()
    {
        return Insumo::where('estado','ACTIVO')->get();
    }
}
if (!function_exists('generarQrApi')) {
    function generarQrApi($comprobante)
    {
        $url = "https://facturacion.apisperu.com/api/v1/sale/qr";
        $client =  new \GuzzleHttp\Client(['verify'=>false]);
        $token = Apis::findOrFail(3)->token;
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ],
            'body'    => $comprobante
        ]);
        $estado = $response->getStatusCode();
        return $response->getBody();
        if ($estado == '200') {

            $resultado = $response->getBody()->getContents();
            json_decode($resultado);
            return $resultado;
        }
    }
}
if (!function_exists('enviarComprobanteapi')) {
    function enviarComprobanteapi($comprobante)
    {
        $url = "https://facturacion.apisperu.com/api/v1/invoice/send";
        $client = new \GuzzleHttp\Client(['verify'=>false]);
        $token = Apis::findOrFail(3)->token;
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ],
            'body'    => $comprobante
        ]);

        $estado = $response->getStatusCode();

        if ($estado == '200') {

            $resultado = $response->getBody()->getContents();
            json_decode($resultado);
            return $resultado;
        }
    }
}
if (!function_exists('generarComprobanteapi')) {
    function generarComprobanteapi($comprobante)
    {
        $url = "https://facturacion.apisperu.com/api/v1/invoice/pdf";
        $client = new \GuzzleHttp\Client(['verify'=>false]);
        $token = Apis::findOrFail(3)->token;
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$token}"
            ],
            'body'    => $comprobante
        ]);

        $estado = $response->getStatusCode();

        return $response->getBody()->getContents();

        dd($response->getBody()->getContents());
        if ($estado == '200') {

            $resultado = $response->getBody()->getContents();
            json_decode($resultado);
            return $resultado;
        }
    }
}
