@extends('layout.index')
@section('contenido')
@section('almacenM-active', 'active')
@section('notaIngreso-active', 'active')
<div id="app">
    <notaingresoindex-component >
    </notaingresoindex-component>
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
