<?php

namespace Modules\Tasks\Policies;


use Modules\Tasks\Entities\Task;
use Modules\Users\Entities\User;

/**
 * Class TaskPolicy
 * @package Modules\Tasks\Policies
 */
class TaskPolicy
{

    /**
     * Can the user view tha task?
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function viewTask(User $user, Task $task)
    {
        if($task->user_id = $user->id)
        {
            return true;
        }
        return $task->whereHas('users', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->count() > 0;
    }

}