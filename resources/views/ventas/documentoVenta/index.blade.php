@extends('layout.index')
@section('contenido')
@section('ventas-active', 'active')
@section('docVenta-active', 'active')
<div id="app">
    <documentoventaindex-component :formaspagos="{{ formasPagos() }}" :error="{{ json_encode(session('error')) }}"
        :mensaje="{{ json_encode(session('mensaje')) }}" :tiempophp="{{json_encode($tiempophp)}}">
    </documentoventaindex-component>
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
