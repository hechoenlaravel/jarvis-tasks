<?php

namespace Modules\Tasks\Http\Controllers;

use Auth;
use SweetAlert;
use JavaScript;
use Modules\Tasks\Entities\Board;
use Pingpong\Modules\Routing\Controller;
use Modules\Tasks\Http\Requests\BoardRequest;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class BoardsController
 * @package Modules\Tasks\Http\Controllers
 */
class BoardsController extends Controller{

    use AuthorizesRequests;

    /**
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $myBoards = Board::byUser(Auth::user())->get();
        $boardsIamIn = Board::participating(Auth::user())->get();
        return view('tasks::boards.index', compact('myBoards', 'boardsIamIn'));
    }

    /**
     * @return $this
     */
    public function create()
    {
        $flows = Flow::byModule('tasks')->get()->pluck('name', 'id')->toArray();
        return view('tasks::boards.create')->with('flows', $flows);
    }

    /**
     * @param BoardRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BoardRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $board = Board::create($input);
        SweetAlert::success('Se ha creado el tablero! ahora agrega tareas y personas para colaborar!');
        return redirect()->route('tasks.boards.show', $board->uuid);
    }

    /**
     * @param $uuid
     * @return $this
     */
    public function show($uuid)
    {
        $board = Board::with(['users.user', 'flow', 'user'])->byUuid($uuid)->firstOrFail();
        $this->authorize('viewBoard', $board);
        JavaScript::put([
            'board' => $board->transformed('flow,user,users')->toArray()
        ]);
        return view('tasks::boards.show')->with('board', $board);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function edit($uuid)
    {
        $board = Board::byUuid($uuid)->firstOrFail();
        $this->authorize('editBoard', $board);
        $flows = Flow::byModule('tasks')->get()->pluck('name', 'id')->toArray();
        return view('tasks::boards.edit')
            ->with('flows', $flows)
            ->with('board', $board);
    }

    /**
     * @param BoardRequest $request
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BoardRequest $request, $uuid)
    {
        $board = Board::byUuid($uuid)->firstOrFail();
        $this->authorize('editBoard', $board);
        $board->fill($request->all());
        $board->save();
        SweetAlert::success('Se ha actualizado el tablero!');
        return redirect()->back();
    }

    /**
     * @param $uuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($uuid)
    {
        $board = Board::byUuid($uuid)->firstOrFail();
        $board->delete();
        SweetAlert::success('Se ha eliminado el tablero!');
        return redirect()->route('tasks.boards.index');
    }

}