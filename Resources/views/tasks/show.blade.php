@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tableros"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Tarea: <small>{{$task->name}}</small></h2>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Detalle de la tarea
                    </h3>
                    <div class="box-tools">
                        @foreach($task->step->transitions as $transition)
                            <button class="btn btn-sm btn-default"><i class="fa fa-arrow-right"></i> {{$transition->to->name}}</button>
                        @endforeach
                    </div>
                </div>
                <div class="box-body">
                    <strong>Descripción: </strong>{{$task->description}}<br />
                    <strong>Paso actual: </strong>{{$task->step->name}}
                </div>
                <div class="box-footer">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection