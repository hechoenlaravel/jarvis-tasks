@extends('jplatformui::layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tablero ".$board->name}}
@endsection
@section('styles')

@endsection
@section('content')
    <div ng-controller="BoardController" ng-init="getTasks()">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Tablero <small>@{{board.data.name}}</small>
                        </h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <strong>Descripción del tablero:</strong> @{{board.data.description}} <br />
                        <strong>Flujo:</strong> @{{board.data.flow.data.name}}<br />
                        <strong>Descripción del flujo:</strong> @{{board.data.flow.data.description}}<br />
                    </div>
                    <div class="box-footer">
                        @can('editBoard', $board)
                            <a href="{{route('tasks.boards.edit', $board->uuid)}}" class="btn btn-primary">Editar tablero</a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Usuarios en el tablero
                        </h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            <li>
                                <img src="@{{board.data.user.data.avatar.url}}" alt="@{{board.data.user.data.name}}">
                                <a class="users-list-name" href="#">@{{board.data.user.data.name}}</a>
                                <span class="label label-success">Administrador</span>
                            </li>
                            <li ng-repeat="boardUser in board.data.users.data">
                                <img src="@{{boardUser.user.data.avatar.url}}" alt="@{{boardUser.user.data.name}}">
                                <a class="users-list-name" href="#">@{{boardUser.user.data.name}}</a>
                                <span class="label label-default" ng-if="boardUser.can_assign != true">No Asigna</span>
                                <span class="label label-primary" ng-if="boardUser.can_assign != false">Puede Asignar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Buscador de tareas</h3>
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                {!! Field::text('name', null , ['ng-model' => 'tasksParameters.name', 'label' => 'Nombre']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::select('name', [1 => 'Baja', 2 => 'Media', 3 => 'Alta'], null , ['ng-model' => 'tasksParameters.priority', 'label' => 'Prioridad', 'class' => 'select2']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::text('due_date', null , ['ng-model' => 'tasksParameters.dueDate', 'label' => 'Fecha de vencimiento', 'class' => 'daterange-left']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                {!! Field::select('step', $board->flow->steps->pluck('name', 'id')->toArray() ,null , ['ng-model' => 'tasksParameters.step', 'label' => 'Paso del flujo actual', 'class' => 'select2', 'multiple' => 'multiple']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::text('created', null , ['ng-model' => 'tasksParameters.created', 'label' => 'Fecha de creación', 'class' => 'daterange-left']) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::select('users', $usersForSelect, null , ['ng-model' => 'tasksParameters.users', 'label' => 'Usuarios', 'class' => 'select2', 'multiple' => 'multiple']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-default btn-block btn-margin-top" data-loading-text="Buscando..." ng-click="searchTasks()" id="tasksSearchButton"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Tareas
                        </h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>Tarea</th>
                                    <th>Fecha de creación</th>
                                    <th>Prioridad</th>
                                    <th>Paso actual</th>
                                    <th>Fecha de vencimiento</th>
                                    <th>Asignados</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="task in tasks">
                                    <td>@{{ task.name }}</td>
                                    <td>@{{ task.created.formatted }}</td>
                                    <td>@{{ task.priority.formatted }}</td>
                                    <td>@{{ task.step.data.name }}</td>
                                    <td>@{{ task.due_date.formatted }}</td>
                                    <td>
                                        <span ng-repeat="user in task.users.data">
                                            @{{user.name}}<br />
                                        </span>
                                    </td>
                                    <td>
                                        <a href="@{{ task.links.self }}" class="btn btn-sm btn-default">Ver Tarea</a>
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
    <script src="{{asset('modules/tasks/js/board.js')}}"></script>
@endsection