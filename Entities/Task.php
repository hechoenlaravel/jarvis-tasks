<?php

namespace Modules\Tasks\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;

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
    protected $fillable = ['user_id', 'board_id', 'name', 'description', 'due_date', 'priority'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'due_date'];

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
        return $this->belongsToMany(User::class, 'tasks_tasks_user');
    }

}