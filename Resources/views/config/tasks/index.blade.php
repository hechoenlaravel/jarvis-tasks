@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Configuración de tareas"}}
@endsection
@section('styles')

@endsection
@section('content-header')
    <h2><i class="fa fa-cog"></i> Configuración de tareas</h2>
    <p>Utilice las opciones de esta sección para configurar las tareas del módulo.</p>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-table"></i> Campos de las tareas</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1" ng-controller="TasksSettingsController" ng-init="getFields()">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-10">
                                <a href="{{route('tasks.config.create')}}" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Agregar campo</a>
                            </div>
                        </div>
                        <table class="table table-condensed table-striped" ng-cloak>
                            <thead>
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tipo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody ng-sortable="fieldsConfig">
                            <tr ng-repeat="field in fields">
                                <td>
                                    <i class="fa fa-sort"></i>
                                </td>
                                <td>@{{ field.name }}</td>
                                <td>@{{ field.description }}</td>
                                <td>@{{ field.fieldType.name }}</td>
                                <td>
                                    @if(Auth::user()->can('config-tasks'))
                                        <a href="@{{ field.links.edit }}" data-toggle="tooltip" data-placement="top" title="Editar campo" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                                        <button ng-click="deleteField(field.id)" data-toggle="tooltip" data-placement="top" title="Eliminar campo" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('modules/tasks/js/tasks-config.js')}}"></script>
@endsection