<?php

namespace Modules\Tasks\Http\Controllers;

use DB;
use Auth;
use SweetAlert;
use JavaScript;
use Modules\Tasks\Entities\Board;
use Pingpong\Modules\Routing\Controller;
use Modules\Tasks\Http\Requests\BoardRequest;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;
use Hechoenlaravel\JarvisFoundation\Traits\EntryManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Hechoenlaravel\JarvisFoundation\UI\Field\EntityFieldsFormBuilder;
use Hechoenlaravel\JarvisFoundation\Exceptions\EntryValidationException;

/**
 * Class BoardsController
 * @package Modules\Tasks\Http\Controllers
 */
class BoardsController extends Controller{

    use AuthorizesRequests, EntryManager;

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
    public function create(Board $entity)
    {
        $flows = Flow::byModule('tasks')->get()->pluck('name', 'id')->toArray();
        $builder = new EntityFieldsFormBuilder($entity->getEntity());
        return view('tasks::boards.create')->with('flows', $flows)
            ->with('boardFields', $builder->render());
    }

    /**
     * @param BoardRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BoardRequest $request, Board $entity)
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $board = Board::create($input);
            $this->updateEntry($entity->getEntity()->id, $board->id, ['input' => $request->all()]);
            DB::commit();
            SweetAlert::success('Se ha creado el tablero! ahora agrega tareas y personas para colaborar!');
        }catch (EntryValidationException $e)
        {
            DB::rollBack();
            SweetAlert::error('Ha ocurrido un problema de validación, verifica los campos adicionales del tablero!');
            return back()->withInput($request->all())->withErrors($e->getErrors());
        }
        return redirect()->route('tasks.boards.show', $board->uuid);
    }

    /**
     * @param $uuid
     * @return $this
     */
    public function show($uuid)
    {
        $board = Board::with(['users.user', 'flow.steps', 'user'])->byUuid($uuid)->firstOrFail();
        $this->authorize('viewBoard', $board);
        $users = $board->users->pluck('user.name', 'user.id')->toArray();
        $users[$board->user->id] = $board->user->name;
        JavaScript::put([
            'board' => $board->transformed('flow.steps,user,users')->toArray()
        ]);
        return view('tasks::boards.show')->with('board', $board)->with('usersForSelect', $users);
    }

    /**
     * @param $uuid
     * @return mixed
     */
    public function edit(Board $entity, $uuid)
    {
        $board = Board::byUuid($uuid)->firstOrFail();
        $this->authorize('editBoard', $board);
        $flows = Flow::byModule('tasks')->get()->pluck('name', 'id')->toArray();
        $builder = new EntityFieldsFormBuilder($entity->getEntity());
        $builder->setRowId($board->id);
        return view('tasks::boards.edit')
            ->with('flows', $flows)
            ->with('board', $board)
            ->with('boardFields', $builder->render());
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
        DB::beginTransaction();
        try {
            $board->fill($request->all());
            $board->save();
            $this->updateEntry($board->getEntity()->id, $board->id, ['input' => $request->all()]);
            DB::commit();
            SweetAlert::success('Se ha actualizado el tablero!');
        }catch (EntryValidationException $e)
        {
            DB::rollBack();
            SweetAlert::error('Ha ocurrido un problema de validación, verifica los campos adicionales del tablero!');
            return back()->withInput($request->all())->withErrors($e->getErrors());
        }
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