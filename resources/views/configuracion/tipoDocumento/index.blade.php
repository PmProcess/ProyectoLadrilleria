@extends('layout.index')
@section('contenido')
    <div id="app">
        <tipodocumentoindex-component></tipodocumentoindex-component>
    </div>
@endsection
@section('css-vue')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('script-vue')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
