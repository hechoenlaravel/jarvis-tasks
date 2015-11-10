<?php

namespace Modules\Tasks\Policies;

use Modules\Users\Entities\User;
use Modules\Tasks\Entities\Board;

/**
 * Class BoardPolicy
 * @package Modules\Tasks\Policies
 */
class BoardPolicy
{
    /**
     * Can the user see the board?
     * @param Board $board
     * @param User $user
     * @return bool
     */
    public function viewBoard(User $user, Board $board)
    {
        if($board->user->id === $user->id) {
            return true;
        }
        return $board->whereHas('users', function($q) use ($user){
            $q->where('id', $user->id);
        })->count() > 0;
    }

    /**
     * @param Board $board
     * @param User $user
     * @return bool
     */
    public function editBoard(User $user, Board $board)
    {
        if($board->user->id === $user->id) {
            return true;
        }
        return false;
    }
}