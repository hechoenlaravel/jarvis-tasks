<?php namespace Modules\Tasks\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Tasks\Entities\Task;
use Pingpong\Modules\Routing\Controller;
use Modules\Tasks\Transformers\TaskTransformer;
use Joselfonseca\LaravelApiTools\Traits\ResponderTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class TasksController
 * @package Modules\Tasks\Http\Controllers
 */
class TasksController extends Controller {

    use ResponderTrait, AuthorizesRequests;

    /**
     * @param Request $request
     * @param Task $model
     * @param $uuid
     * @return mixed
     */
    public function index(Request $request, Task $model, $uuid)
	{
		$tasks = $model->with(['user', 'step', 'users'])->byBoard($uuid);
        $this->setCriteria($request, $tasks);
		if($request->has('limit'))
		{
			return $this->responseWithPaginator($request->get('limit'), $tasks->orderBy('due_date'), new TaskTransformer());
		}
        return $this->responseWithCollection($tasks->orderBy('due_date'), new TaskTransformer());
	}

    /**
     * @param $taskId
     */
    public function show(Task $model, $boardId, $taskId)
    {
        $task = $model->with(['user', 'step', 'users'])->ByUuid($taskId)->firstOrFail();
        $this->authorize('viewTask', $task);
        return view('tasks::tasks.show')->with('task', $task);
    }

    /**
     * Set the tasks criteria
     * @param Request $request
     * @param $tasks
     */
    protected function setCriteria(Request $request, $tasks)
    {
        $request->has('dueDate') ? $tasks->dueDate($request->get('dueDate')) : null;
        $request->has('name') ? $tasks->byName($request->get('name')) : null;
        $request->has('priority') ? $tasks->byPriority($request->get('priority')) : null;
        $request->has('step') ? $tasks->byStep($request->get('step')) : null;
        $request->has('created') ? $tasks->byCreatedDate($request->get('created')) : null;
        $request->has('users') ? $tasks->byUsers($request->get('users')) : null;
    }

}