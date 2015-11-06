<?php namespace Modules\Tasks\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class TasksController extends Controller {
	
	public function index()
	{
		return view('tasks::index');
	}
	
}