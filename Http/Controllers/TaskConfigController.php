<?php

namespace Modules\Tasks\Http\Controllers;

use JavaScript;
use Pingpong\Modules\Routing\Controller;
use Hechoenlaravel\JarvisFoundation\UI\Field\FormBuilder;
use Hechoenlaravel\JarvisFoundation\FieldGenerator\FieldModel;
use Hechoenlaravel\JarvisFoundation\EntityGenerator\EntityModel;

class TaskConfigController extends Controller
{

    public function index()
    {
        $entity = EntityModel::where('slug', 'tasks')
            ->where('namespace', 'tasks')
            ->firstOrFail();
        JavaScript::put([
            'entity_id' => $entity->id
        ]);

        return view('tasks::config.tasks.index');
    }

    public function create()
    {
        $entity = EntityModel::where('slug', 'tasks')
            ->where('namespace', 'tasks')
            ->firstOrFail();
        $builder = new FormBuilder($entity);
        $builder->setReturnUrl(route('tasks.config.index'));
        JavaScript::put([
            'entity_id' => $entity->id
        ]);

        return view('tasks::config.tasks.create')
            ->with('form', $builder->render());
    }

    /**
     * Edit a field for the Board
     * @param int $id ID of the field
     * @return $this
     */
    public function edit($id)
    {
        $field = FieldModel::findOrFail($id);
        $entity = $field->entity;
        $builder = new FormBuilder($entity);
        $builder->setReturnUrl(route('tasks.config.index'));
        $builder->setModel($field);
        JavaScript::put([
            'entity_id' => $entity->id,
            'field_id' => $field->id
        ]);

        return view('tasks::config.tasks.edit')
            ->with('form', $builder->render());
    }

}