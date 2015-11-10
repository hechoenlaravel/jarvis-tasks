@extends('layouts.withsidebar')
@section('pageTitle')
    {{isset($pageTitle) ? $pageTitle : "Tablero ".$board->name}}
@endsection
@section('styles')

@endsection
@section('content')
    <div class="row" ng-controller="BoardController">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Tablero <small>{{$board->name}}</small>
                    </h3>
                    <div class="box-tools pull-right">

                    </div>
                </div>
                <div class="box-body">
                    <strong>Flujo:</strong> {{$board->flow->name}}<br />
                    <strong>Descripción:</strong> {{$board->flow->description}}
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
                            <img src="{{$board->user->getAvatarImageUrl()}}" alt="{{$board->user->name}}">
                            <a class="users-list-name" href="#">{{$board->user->name}}</a>
                            <span class="label label-success">Administrador</span>
                        </li>
                        @foreach($board->users as $user)
                            <li>
                                <img src="{{$user->user->getAvatarImageUrl()}}" alt="{{$user->user->name}}">
                                <a class="users-list-name" href="#">{{$user->user->name}}</a>
                                @if($user->can_assign)
                                    <span class="label label-primary">Puede asignar</span>
                                @else
                                    <span class="label label-default">No puede asignar</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('modules/tasks/js/board.js')}}"></script>
@endsection