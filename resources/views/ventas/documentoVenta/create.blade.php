@extends('layout.index')
@section('contenido')
    <div id="app">
        <documentoventacreate-component :old="{{ json_encode(Session::getOldInput()) }}"
            :cliente_v="{{ json_encode(getClientes()) }}" :tipopago_v="{{json_encode(getTipoPagos())}}"
            :tipodocumento_v="{{json_encode(getTipoDocumentos())}}"
            :producto_v="{{json_encode(getProductos('VENTA'))}}"
            :csrf="{{ json_encode(csrf_token()) }}"
            :errores_laravel="{{json_encode(session('errores'))}}"
            :tipomoneda_v="{{json_encode(getTipoMoneda())}}"
            :error="{{json_encode(session('error'))}}"
            ></documentoventacreate-component>
    </div>
@endsection
@section('css-vue')
    <link rel="stylesheet" href="{{ asset('css/app.css?v=' . rand()) }}">
@endsection
@section('script-vue')
    <script src="{{ asset('js/app.js?v=' . rand()) }}">
    </script>
@endsection
