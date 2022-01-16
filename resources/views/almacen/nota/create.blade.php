@extends('layout.index')
@section('contenido')
@section('almacenM-active', 'active')
@section('notaIngreso-active', 'active')
<div id="app">
    <notaingresocreate-component :old="{{ json_encode(Session::getOldInput()) }}"
    :almacen_v="{{json_encode(getAlmacenes())}}"
    :producto_v="{{json_encode(getProductos())}}"
    :csrf="{{ json_encode(csrf_token()) }}"
    :errores_laravel="{{json_encode(session('errores'))}}"
    :error="{{json_encode(session('error'))}}">
    </notaingresocreate-component>
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
