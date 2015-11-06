<?php

Route::group(['prefix' => 'tasks', 'namespace' => 'Modules\Tasks\Http\Controllers'], function()
{
	Route::get('/boards', ['as' => 'boards.index', 'uses' => 'BoardsController@index']);
});