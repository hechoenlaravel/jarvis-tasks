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
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Crear tablero
                    </h3>
                </div>
                <div class="box-body">

                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

@endsection