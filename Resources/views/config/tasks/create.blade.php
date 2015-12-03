@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Agregar campo a las tareas"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-table"></i> Agregar campo a las tareas</h2>
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
    <script src="{{asset('modules/tasks/js/tasks-config.js')}}"></script>
@endsection