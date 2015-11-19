<?php

namespace Modules\Tasks\Repositories;

use Pingpong\Modules\Facades\Module;
use Hechoenlaravel\JarvisFoundation\Traits\EntityManager;

/**
 * Class EntitiesGenerator
 * @package Modules\Tasks\Repositories
 */
class EntitiesGenerator
{

    use EntityManager;

    /**
     * The module
     * @var
     */
    protected $module;

    /**
     *
     */
    public function __construct()
    {
        $this->module = Module::find('tasks');
    }

    /**
     * Generate the Entities and fields for the Tasks module
     */
    public function generate()
    {
        $this->createBoardEntity();
        $this->createTaskEntity();
    }

    /**
     * Create the Board Entity
     * @return mixed
     */
    protected function createBoardEntity()
    {
        $data = [
            'namespace' => 'tasks',
            'name' => 'Tableros',
            'description' => 'Los tableros del módulo de tareas',
            'slug' => 'boards',
            'locked' => 1,
            'create_table' => 0
        ];
        $entity = $this->generateEntity($data);

        return $entity;
    }
    /**
     * Create the Task Entity
     * @return mixed
     */
    protected function createTaskEntity()
    {
        $data = [
            'namespace' => 'tasks',
            'name' => 'Tareas',
            'description' => 'Las tareas en el módulo de tareas',
            'slug' => 'tasks',
            'locked' => 1,
            'create_table' => 0
        ];
        $entity = $this->generateEntity($data);

        return $entity;
    }
}