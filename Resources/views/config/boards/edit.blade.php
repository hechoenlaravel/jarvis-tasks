@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Editar campo del tablero"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-table"></i> Editar campo del tablero</h2>
    <p>Edite la información del campo</p>
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
    <script>
        window.isEdit = true;
    </script>
@endsection