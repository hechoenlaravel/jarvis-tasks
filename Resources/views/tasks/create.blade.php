@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Crear Tarea"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Crear tarea en tablero: <small>{{$board->name}}</small></h2>
@endsection
@section('content')

@endsection
@section('scripts')

@endsection