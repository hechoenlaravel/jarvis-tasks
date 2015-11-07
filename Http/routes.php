<?php

Route::group(['prefix' => 'tasks', 'namespace' => 'Modules\Tasks\Http\Controllers', 'middleware' => ['auth']], function()
{
	Route::resource('/boards', 'BoardsController');
    Route::group(['prefix' => 'config', 'middleware' => ['acl:config-tasks']], function(){
        Route::resource('flows', 'ConfigController');
    });
});