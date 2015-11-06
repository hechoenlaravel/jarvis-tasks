<?php

namespace Modules\Tasks\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class BoardsController extends Controller{

    public function index()
    {
        return view('tasks::boards.index');
    }

}