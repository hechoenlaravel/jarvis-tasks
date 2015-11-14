<?php

namespace Modules\Tasks\Transformers;

use Modules\Tasks\Entities\Task;
use League\Fractal\TransformerAbstract;
use Modules\Users\Transformers\UserTransformer;
use Hechoenlaravel\JarvisFoundation\Flows\Transformers\StepTransformer;

/**
 * Class TaskTransformer
 * @package Modules\Tasks\Transformers
 */
class TaskTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $availableIncludes = ['user', 'board', 'users', 'step'];

    /**
     * @param Task $task
     * @return array
     */
    public function transform(Task $task)
    {
        return [
            'id' => (int) $task->id,
            'uuid' => $task->uuid,
            'name' => $task->name,
            'description' => $task->description,
            'due_date' => [
                'unix' => (!empty($task->due_date)) ? $task->due_date->format('U') : null,
                'formatted' => (!empty($task->due_date)) ? $task->due_date->format('m/d/Y') : null,
            ],
            'priority' => [
                'weigth' => $task->priority,
                'formatted' => $task->getPriorityText()
            ],
            'closed' => (bool) $task->closed,
            'created' => [
                'unix' => $task->created_at->format('U'),
                'formatted' => $task->created_at->format('m/d/Y h:i A')
            ],
            'updated' => [
                'unix' => $task->updated_at->format('U'),
                'formatted' => $task->updated_at->format('m/d/Y h:i A')
            ],
            'links' => [
                'self' => route('tasks.boards.{board}.tasks.show', [$task->board->uuid, $task->uuid])
            ]
        ];
    }

    /**
     * @param Task $task
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Task $task)
    {
        return $this->item($task->user, new UserTransformer());
    }

    /**
     * @param Task $task
     * @return \League\Fractal\Resource\Item
     */
    public function includeBoard(Task $task)
    {
        return $this->item($task->board, new BoardTransformer());
    }

    /**
     * @param Task $task
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeUsers(Task $task)
    {
        if($task->users->count() > 0){
            return $this->collection($task->users, new UserTransformer());
        }
        return null;
    }

    /**
     * @param Task $task
     * @return \League\Fractal\Resource\Item
     */
    public function includeStep(Task $task)
    {
        return $this->item($task->step, new StepTransformer());
    }

}