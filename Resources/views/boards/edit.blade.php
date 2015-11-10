@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tableros"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Editar tablero <small>{{$board->name}}</small></h2>
    <p>Ingresa la información necesaria para crear un tablero.</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Editar tablero
                    </h3>
                </div>
                {!! Form::model($board, ['route' => ['tasks.boards.update', $board->uuid], 'method' => 'PUT']) !!}
                <div class="box-body">
                    <div class="col-md-6">
                        {!! Field::text('name', ['label' => 'Nombre del tablero']) !!}
                        {!! Field::textarea('description', ['label' => 'Descripción del tablero']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Field::select('flow_id', $flows, null, ['label' => 'Flujo para usar en el tablero', 'class' => 'select2']) !!}
                        <small>Los flujos son un mecanismo para que las tareas sigan un proceso determinado, estos flujos se pueden administrar en la configuración del módulo</small>
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit('Actualizar tablero', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection