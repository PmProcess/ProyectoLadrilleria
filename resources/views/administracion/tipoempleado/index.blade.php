@extends('layout.index')
@section('contenido')
@section('administracion-active', 'active')
@section('tipoempleado-active', 'active')
<div id="app">
    <tipoempleadoindex-component>
    </tipoempleadoindex-component>
</div>
@endsection
@section('css-vue')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('script-vue')
<script src="{{ asset('js/app.js?v=' . rand()) }}"></script>
@endsection
