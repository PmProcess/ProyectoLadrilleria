@extends('layout.index')
@section('contenido')
@section('ventas-active', 'active')
@section('cotizacion-active', 'active')
<div id="app">
    <cotizacionindex-component  :error="{{ json_encode(session('error')) }}"
        :mensaje="{{ json_encode(session('mensaje')) }}">
    </cotizacionindex-component>
</div>
@endsection
@section('css-vue')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('script-vue')
<script src="{{ asset('js/app.js?v='.rand()) }}"></script>
@endsection
@section('css-custom')
@endsection
@section('script-custom')
@endsection
