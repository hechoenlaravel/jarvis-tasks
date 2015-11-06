<?php

namespace Modules\Tasks\Entities;

use Modules\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;

/**
 * Class Board
 * @package Modules\Tasks\Entities
 */
class Board extends Model{

    /**
     * @var string
     */
    public $table = "tasks_boards";

    /**
     * @var array
     */
    protected $fillable = ['flow_id', 'user_id', 'name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(BoardUser::class, 'board_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }

    /**
     * @param $query
     * @param User $user
     * @return mixed
     */
    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    /**
     * @param $query
     * @param User $user
     * @return mixed
     */
    public function scopeParticipating($query, User $user)
    {
        return $query->whereHas('users', function($q) use($user){
            $q->where('user_id', $user->id);
        });
    }

}