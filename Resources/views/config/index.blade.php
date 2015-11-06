@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Flujos"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-columns"></i> Flujos</h2>
    <p>Desde acá podrá administrar los flujos para los tableros.</p>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Flujos para los tableros
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="{{route('tasks.config.flows.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Crear tablero</a>
                    </div>
                </div>
                <div class="box-body">
                    {!! $html->table() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {!! $html->scripts() !!}
@endsection