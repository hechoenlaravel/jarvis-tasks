<?php namespace Modules\Tasks\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Tasks\Entities\Task;
use Pingpong\Modules\Routing\Controller;
use Modules\Tasks\Transformers\TaskTransformer;
use Joselfonseca\LaravelApiTools\Traits\ResponderTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TasksController extends Controller {

    use ResponderTrait, AuthorizesRequests;
	
	public function index(Request $request, $uuid)
	{
		$tasks = Task::byBoard($uuid)->with(['user', 'step', 'users'])->orderBy('due_date');
		if($request->has('limit'))
		{
			return $this->responseWithPaginator($request->get('limit'), $tasks, new TaskTransformer());
		}
        return $this->responseWithCollection($tasks, new TaskTransformer());
	}

    public function show($taskId)
    {
        $task = Task::ByUuid($taskId)->firstOrFail();
        $this->authorize('viewTask', $task);
    }
	
}