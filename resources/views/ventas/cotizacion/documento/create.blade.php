@extends('layout.index')
@section('ventas-active', 'active')
@section('docVenta-active', 'active')
@section('contenido')
    <div id="app">
        <documentoventacotizacioncreate-component :old="{{ json_encode(Session::getOldInput()) }}"
            :cliente_v="{{ json_encode(getClientes()) }}" :formapago_v="{{json_encode(getFormaPagos())}}"
            :tipodocumento_v="{{json_encode(getTipoDocumentos())}}"
            :producto_v="{{json_encode(getProductos())}}"
            :csrf="{{ json_encode(csrf_token()) }}"
            :errores_laravel="{{json_encode(session('errores'))}}"
            :tipomoneda_v="{{json_encode(getTipoMoneda())}}"
            :error="{{json_encode(session('error'))}}"
            :cotizacion="{{json_encode($cotizacion)}}"
            ></documentoventacotizacioncreate-component>
    </div>
@endsection
@section('css-vue')
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . rand()) }}">
@endsection
@section('script-vue')
    <script src="{{ asset('js/app.js?v=' . rand()) }}">
    </script>
@endsection
