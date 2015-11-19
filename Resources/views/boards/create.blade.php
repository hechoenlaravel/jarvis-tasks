@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tableros"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Crear tablero</h2>
    <p>Ingresa la información necesaria para crear un tablero.</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-table"></i> Información básica</a></li>
                        <li><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-table"></i> Campos adicionales</a></li>
                    </ul>
                </div>
                {!! Form::open(['route' => 'tasks.boards.store']) !!}
                <div class="box-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Field::text('name', ['label' => 'Nombre del tablero']) !!}
                                    {!! Field::textarea('description', ['label' => 'Descripción del tablero']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::select('flow_id', $flows, null, ['label' => 'Flujo para usar en el tablero', 'class' => 'select2']) !!}
                                    <small>Los flujos son un mecanismo para que las tareas sigan un proceso determinado, estos flujos se pueden administrar en la configuración del módulo</small>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane active" id="tab_2">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! $boardFields !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit('Crear tablero', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection