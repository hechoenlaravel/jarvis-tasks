<?php

namespace Modules\Tasks\Entities;

use Carbon\Carbon;
use Modules\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Hechoenlaravel\JarvisFoundation\Flows\Step;

/**
 * Class Task
 * @package Modules\Tasks\Entities
 */
class Task extends Model{

    /**
     * @var string
     */
    public $table = "tasks_tasks";

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'board_id', 'name', 'description', 'due_date', 'priority', 'step_id', 'uuid'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'due_date'];

    /**
     * Taks priority
     * @var array
     */
    protected $priorities = [3 => 'Alta', 2 => 'Media', 1 => 'Baja'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'tasks_tasks_users');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function step()
    {
        return $this->belongsTo(Step::class);
    }

    /**
     * @param $query
     * @param $boardId
     * @return mixed
     */
    public function scopeByBoard($query, $boardUuid)
    {
        return $query->whereHas('board', function($q) use($boardUuid){
            $q->where('uuid', $boardUuid);
        });
    }

    /**
     * @param $query
     * @param $taskUuid
     * @return mixed
     */
    public function scopeByUuid($query, $taskUuid)
    {
        return $query->where('uuid', $taskUuid);
    }

    /**
     * Scope for Due Date filter
     * @param $query
     * @param $dueDate
     * @return mixed
     */
    public function scopeDueDate($query, $dueDate)
    {
        $dates = explode(' - ', $dueDate);
        if(isset($dates[0]) && isset($dates[1]))
        {
            return $query->where('due_date', '>=', Carbon::createFromTimestamp(strtotime($dates[0]))->format('Y-m-d'))->where('due_date', '<=', Carbon::createFromTimestamp(strtotime($dates[1]))->format('Y-m-d'));
        }
    }

    /**
     * Filter by name
     * @param $query
     * @param $name
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', 'LIKE', '%'.$name.'%');
    }

    /**
     * Filter by priority
     * @param $query
     * @param $priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Filter by Scope
     * @param $query
     * @param $step
     * @return mixed
     */
    public function scopeByStep($query, $step)
    {
        return $query->whereIn('step_id', $step);
    }

    /**
     * Scope by created Date
     * @param $query
     * @param $created
     * @return mixed
     */
    public function scopeByCreatedDate($query, $created)
    {
        $dates = explode(' - ', $created);
        if(isset($dates[0]) && isset($dates[1]))
        {
            return $query->where('created_at', '>=', Carbon::createFromTimestamp(strtotime($dates[0]))->format('Y-m-d'))->where('created_at', '<=', Carbon::createFromTimestamp(strtotime($dates[1]))->format('Y-m-d'));
        }
    }

    /**
     * @param $query
     * @param $users
     * @return mixed
     */
    public function scopeByUsers($query, $users)
    {
        return $query->whereHas('users', function($q) use($users){
            $q->whereIn('user_id', $users);
        });
    }

    /**
     * Get the priority text
     * @return string
     */
    public function getPriorityText()
    {
        if(isset($this->priorities[(int)$this->priority])){
            return $this->priorities[(int)$this->priority];
        }
        return "Baja";
    }

}