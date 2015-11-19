<?php

namespace Modules\Tasks\Entities;

use Hechoenlaravel\JarvisFoundation\EntityGenerator\EntityModel;
use League\Fractal\Manager;
use Modules\Users\Entities\User;
use League\Fractal\Resource\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;
use Modules\Tasks\Transformers\BoardTransformer;

/**
 * Class Board
 * @package Modules\Tasks\Entities
 */
class Board extends Model{

    use SoftDeletes;

    /**
     * @var string
     */
    public $table = "tasks_boards";

    /**
     * @var array
     */
    protected $fillable = ['flow_id', 'user_id', 'name', 'uuid', 'description'];

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
     * @param $uuid
     * @return mixed
     */
    public function scopeByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
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

    /**
     * @param string $includes
     * @return \League\Fractal\Scope
     */
    public function transformed($includes = "")
    {
        $manager = new Manager;
        $resource = new Item($this, new BoardTransformer());
        return $manager->parseIncludes($includes)->createData($resource);
    }

    public function getEntity()
    {
        return EntityModel::where('slug', 'boards')->where('namespace', 'tasks')->first();
    }

}