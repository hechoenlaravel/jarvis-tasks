@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Agregar campo al tablero"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-table"></i> Agregar campo al tablero</h2>
    <p>Agregue el tipo de campo que desea agregar</p>
@endsection
@section('content')
    <div class="box">
        <div class="box-body">
            {!! $form !!}
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('modules/tasks/js/boards-config.js')}}"></script>
@endsection