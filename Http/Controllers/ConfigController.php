<?php

namespace Modules\Tasks\Http\Controllers;

use Datatables;
use SweetAlert;
use Illuminate\Http\Request;
use yajra\Datatables\Html\Builder;
use Pingpong\Modules\Routing\Controller;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;
use Hechoenlaravel\JarvisFoundation\Flows\UI\FlowForm;
use Hechoenlaravel\JarvisFoundation\Traits\FlowManager;

/**
 * Class ConfigController
 * @package Modules\Tasks\Http\Controllers
 */
class ConfigController extends Controller{

    use FlowManager;

    /**
     * Datatables Html Builder
     * @var Builder
     */
    protected $htmlBuilder;

    /**
     * @param Builder $htmlBuilder
     */
    public function __construct(Builder $htmlBuilder)
    {
        $this->htmlBuilder = $htmlBuilder;
    }

    /**
     * Lists the flows for the module
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Datatables::of(Flow::select(['id', 'name', 'description', 'active'])->where('module', 'tasks'))
                ->addColumn('actions', function ($flow) {
                    return $this->getButtons($flow);
                })
                ->addColumn('activePresented', function ($flow) {
                    return $flow->activePresented;
                })
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Nombre'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Descripción'])
            ->addColumn(['data' => 'activePresented', 'name' => 'activePresented', 'title' => 'Activo'])
            ->addColumn(['data' => 'actions', 'name' => 'actions', 'title' => '']);

        return view('tasks::config.index', compact('html'));
    }

    /**
     * @param FlowForm $form
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(FlowForm $form)
    {
        $form->setModule('tasks')->setReturnBaseUrl('tasks/config/flows');
        $view = $form->render();
        return view('tasks::config.form', compact('view'));
    }

    /**
     * @param FlowForm $form
     * @param $id
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(FlowForm $form, $id)
    {
        $form->setModule('tasks')->setFlow($id)->setReturnBaseUrl('config/flows');
        $view = $form->render();
        return view('tasks::config.form', compact('view'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->deleteFlow(Flow::findOrFail($id));
        SweetAlert::success('Se ha eliminado el Flujo');
        return redirect()->back();
    }

    /**
     * @param $flow
     * @return string
     */
    protected function getButtons($flow)
    {
        $button = '<a href="'.route('tasks.config.flows.edit', ['id' => $flow->id]).'" data-toggle="tooltip" data-placement="top" title="Editar flujo" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>&nbsp';
        $button .= '<a href="'.route('tasks.config.flows.destroy', ['id' => $flow->id]).'" data-toggle="tooltip" data-placement="top" title="Eliminar flujo" class="btn btn-sm btn-danger confirm-delete"><i class="fa fa-times"></i></a>';
        return $button;
    }

}