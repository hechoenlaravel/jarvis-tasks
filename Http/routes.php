<?php

Route::group(['namespace' => 'Modules\Tasks\Http\Controllers', 'middleware' => ['auth']], function() {
    Route::resource('boards/config', 'BoardConfigController');
    Route::resource('/boards', 'BoardsController');
    Route::resource('/boards/{board}/tasks', 'TasksController', ['exept' => 'index']);
    Route::group(['prefix' => 'tasks'], function(){
        Route::group(['middleware' => ['acl:config-tasks']], function(){
            Route::resource('/config', 'TaskConfigController');
            Route::resource('/flows', 'ConfigController');
        });
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