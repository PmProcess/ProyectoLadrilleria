@extends('layout.index')
@section('contenido')
@section('compra-active', 'active')
@section('documentoCompra-active', 'active')
<div id="app">
    <documentocompracreate-component :old="{{ json_encode(Session::getOldInput()) }}"
    :proveedor_v="{{ json_encode(getProveedores()) }}"
    :formapago_v="{{json_encode(getFormaPagos())}}"
    :tipodocumento_v="{{json_encode(getTipoDocumentos())}}"
    :almacen_v="{{json_encode(getAlmacenes())}}"
    :insumo_v="{{json_encode(getInsumos())}}"
    :csrf="{{ json_encode(csrf_token()) }}"
    :errores_laravel="{{json_encode(session('errores'))}}"
    :error="{{json_encode(session('error'))}}">
    </documentocompracreate-component>
</div>
@endsection
@section('css-vue')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('script-vue')
<script src="{{ asset('js/app.js') }}"></script>
@endsection
@section('css-custom')
@endsection
@section('script-custom')
@endsection
