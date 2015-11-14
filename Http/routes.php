<?php

Route::group(['prefix' => 'tasks', 'namespace' => 'Modules\Tasks\Http\Controllers', 'middleware' => ['auth']], function() {
    Route::resource('/boards', 'BoardsController');
    Route::resource('/boards/{board}/tasks', 'TasksController', ['exept' => 'index']);
    Route::group(['prefix' => 'config', 'middleware' => ['acl:config-tasks']], function(){
        Route::resource('flows', 'ConfigController');
    });
});


/** Module API Routes **/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', ['namespace' => 'Modules\Tasks\Http\Controllers'], function ($api) {
    $api->group(['middleware' => ['api.auth'], 'providers' => ['inSession']], function($api) {
        $api->group(['prefix' => 'tasks'], function($api) {
            $api->group(['prefix' => 'boards'], function($api) {
                $api->post('/{board}/tasks', 'TasksController@index');
            });
        });
    });
});