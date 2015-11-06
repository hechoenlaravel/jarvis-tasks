<?php

namespace Modules\Tasks\Entities;

use Illuminate\Database\Eloquent\Model;

class BoardUser extends Model{

    public $table = "tasks_boards_users";

    protected $fillable = ['board_id', 'user_id', 'can_assign'];



}