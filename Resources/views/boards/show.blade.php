@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tablero ".$board->name}}
@endsection
@section('styles')

@endsection
@section('content')
    <div ng-controller="BoardController">
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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Tareas
                        </h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tarea</th>
                                    <th>Fecha de creación</th>
                                    <th>Prioridad</th>
                                    <th>Paso actual</th>
                                    <th>Fecha de vencimiento</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="taks in tasks">
                                    <td>@{{ taks.name }}</td>
                                    <td>@{{ taks.created_at.formatted }}</td>
                                    <td>@{{ taks.priority }}</td>
                                    <td>@{{ taks.step.name }}</td>
                                    <td>@{{ taks.due_date.formatted }}</td>
                                    <td></td>
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