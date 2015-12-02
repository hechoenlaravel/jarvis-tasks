@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Flujo para Tableros"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Flujo para tablero</h2>
@endsection

@section('content')
    {!! $view !!}
@endsection
@section('scripts')

@endsection