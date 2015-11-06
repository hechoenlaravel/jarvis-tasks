<?php

namespace Modules\Tasks\Http\Controllers;

use Datatables;
use Illuminate\Http\Request;
use yajra\Datatables\Html\Builder;
use Pingpong\Modules\Routing\Controller;
use Hechoenlaravel\JarvisFoundation\Flows\Flow;
use Hechoenlaravel\JarvisFoundation\Flows\UI\FlowForm;

/**
 * Class ConfigController
 * @package Modules\Tasks\Http\Controllers
 */
class ConfigController extends Controller{

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
                ->make(true);
        }
        $html = $this->htmlBuilder
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Nombre'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Descripción'])
            ->addColumn(['data' => 'active', 'name' => 'active', 'title' => 'Activo'])
            ->addColumn(['data' => 'actions', 'name' => 'actions', 'title' => '']);

        return view('tasks::config.index', compact('html'));
    }

    public function create(FlowForm $form)
    {
        $form->setModule('tasks')->setReturnBaseUrl('tasks/config/flows');
        $view = $form->render();
        return view('tasks::config.form', compact('view'));
    }

    public function edit(FlowForm $form, $id)
    {
        $form->setModule('tasks')->setFlow($id)->setReturnBaseUrl('config/flows');
        $view = $form->render();
        return view('tasks::config.form', compact('view'));
    }

    protected function getButtons($flow)
    {
        return '<a href="'.route('tasks.config.flows.edit', ['id' => $flow->id]).'" data-toggle="tooltip" data-placement="top" title="Editar flujo" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>';
    }

}