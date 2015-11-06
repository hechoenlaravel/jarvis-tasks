<?php namespace Modules\Tasks\Console;

use Illuminate\Console\Command;
use Modules\Users\Entities\Permission;
use Modules\Users\Entities\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreatePermissions extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'tasks:generate-permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate the permissions for the tasks module';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$create = Permission::create([
            'name' => 'create-tasks',
            'display_name' => 'Crear tareas',
            'description' => 'Permite crear tareas en el sistema',
            'module' => 'tasks'
        ]);
        $assign = Permission::create([
            'name' => 'assign-tasks',
            'display_name' => 'Asignar tareas a usuarios',
            'description' => 'Permite asignar tareas a usuarios en el sistema',
            'module' => 'tasks'
        ]);
        $config = Permission::create([
            'name' => 'config-tasks',
            'display_name' => 'Administrar módulo de tareas',
            'description' => 'Permite que el usuario tenga acceso a la configuracion de el módulo de tareas',
            'module' => 'tasks'
        ]);
        $createBoards = Permission::create([
            'name' => 'create-boards',
            'display_name' => 'Crear tableros',
            'description' => 'Permite crear tableros en el sistema',
            'module' => 'tasks'
        ]);
        $admin = Role::where('name', 'administrador-del-sistema')->first();
        $admin->attachPermissions([$create, $assign, $config, $createBoards]);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [

		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [

		];
	}

}
