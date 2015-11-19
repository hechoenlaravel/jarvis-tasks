<?php namespace Modules\Tasks\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Modules\Tasks\Repositories\EntitiesGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateTasksEntities
 * @package Modules\Tasks\Console
 */
class GenerateTasksEntities extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'tasks:generate-entities';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate the entities for the tasks module.';

	/**
	 * @var EntitiesGenerator
     */
	protected $generator;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(EntitiesGenerator $generator)
	{
		parent::__construct();
		$this->generator = $generator;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->generator->generate();
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
