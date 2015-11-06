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
                <div class="box-body">
                    @if($myBoards->count() === 0)
                        <div class="alert alert-info">
                            <i class="fa fa-info"></i> No tienes tableros creados, crea el primero.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Tableros en los que participo
                    </h3>

                </div>
                <div class="box-body">
                    @if($boardsIamIn->count() === 0)
                        <div class="alert alert-info">
                            <i class="fa fa-info"></i> No tienes tableros compartidos.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection