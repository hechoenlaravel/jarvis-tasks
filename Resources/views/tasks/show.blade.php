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

                    </h3>
                </div>
                <div class="box-body">

                </div>
                <div class="box-footer">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection