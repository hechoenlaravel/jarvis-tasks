<?php

namespace Modules\Tasks\Entities;

use Modules\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Hechoenlaravel\JarvisFoundation\Flows\Step;
use Hechoenlaravel\JarvisFoundation\Support\SearchableTrait;

/**
 * Class Task
 * @package Modules\Tasks\Entities
 */
class Task extends Model{

    use SearchableTrait;

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
    public function byUuid($query, $taskUuid)
    {
        return $query->where('uuid', $taskUuid);
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