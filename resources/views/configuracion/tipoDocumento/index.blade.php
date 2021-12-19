@extends('layout.index')
@section('ventas-active','active')
@section('tipoDocumento-active','active')
@section('contenido')
    <div id="app">
        <tipodocumentoindex-component :json="{{$json}}"></tipodocumentoindex-component>
    </div>
@endsection
@section('css-vue')
    <link rel="stylesheet" href="{{ asset('css/app.css?v='.rand()) }}">
@endsection
@section('script-vue')
    <script src="{{ asset('js/app.js?v='.rand()) }}"></script>
@endsection
