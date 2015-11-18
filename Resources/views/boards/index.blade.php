@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tableros"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Tableros</h2>
    <p>Los tableros te ayudan a organizar tareas, puedes crear y compartir tableros con otros usuarios.</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Mis Tableros
                    </h3>
                    <div class="box-tools pull-right">
                        @if(Auth::user()->can('create-boards'))
                            <a href="{{route('tasks.boards.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Crear tablero</a>
                        @endif
                    </div>
                </div>
                @if($myBoards->count() === 0)
                <div class="box-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info"></i> No tienes tableros creados, crea el primero.
                    </div>
                </div>
                @endif
                <ul class="list-group box-boby">
                @foreach($myBoards as $board)
                    <li class="list-group-item">
                        <div class="pull-right">
                            <a href="{{route('tasks.boards.edit',[$board->uuid] )}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Editar Tablero"><i class="fa fa-pencil"></i></a>
                            <a href="{{route('tasks.boards.destroy',[$board->uuid] )}}" class="btn btn-sm btn-danger confirm-delete" data-toggle="tooltip" data-placement="top" title="Eliminar tablero"><i class="fa fa-trash"></i></a>
                            <a href="{{route('tasks.boards.show', [$board->uuid])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ingresar al tablero"><i class="fa fa-share"></i></a>
                        </div>
                        <strong>{{$board->name}}</strong>
                        <p>{{$board->description}}</p>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Tableros en los que participo
                    </h3>
                </div>
                @foreach($boardsIamIn as $board)
                    <ul class="list-group box-boby">
                        <li class="list-group-item">
                            <div class="pull-right">
                                <a href="{{route('tasks.boards.show', [$board->uuid])}}" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Ingresar al tablero"><i class="fa fa-share"></i></a>
                            </div>
                            <strong>{{$board->name}}</strong>
                            <p>{{$board->description}}</p>
                        </li>
                    </ul>
                @endforeach
                @if($boardsIamIn->count() === 0)
                <div class="box-body">
                    <div class="alert alert-info">
                        <i class="fa fa-info"></i> No tienes tableros compartidos.
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection