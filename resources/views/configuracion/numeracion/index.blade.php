@extends('layout.index')
@section('ventas-active','active')
@section('numeracion-active','active')
@section('contenido')
    <div id="app">
        <numeracionindex-component></numeracionindex-component>
    </div>
@endsection
@section('css-vue')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('script-vue')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
