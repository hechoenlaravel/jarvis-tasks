<?php

namespace Modules\Tasks\Http\Controllers;

use Auth;
use Modules\Tasks\Entities\Board;
use Pingpong\Modules\Routing\Controller;

class BoardsController extends Controller{

    public function index()
    {
        $myBoards = Board::byUser(Auth::user())->get();
        $boardsIamIn = Board::participating(Auth::user())->get();
        return view('tasks::boards.index', compact('myBoards', 'boardsIamIn'));
    }

    public function create()
    {

        return view('tasks::boards.create');
    }

}