<?php namespace Modules\Tasks\Providers;

use Auth;
use MenuPing;
use Modules\Tasks\Entities\Board;
use Illuminate\Support\ServiceProvider;
use Modules\Tasks\Entities\Task;
use Modules\Tasks\Observers\UuidObserver;

class TasksServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();
        $this->registerTranslations();
        $this->registerViews();
        $this->registerMenu();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \Modules\Tasks\Console\CreatePermissions::class,
            \Modules\Tasks\Console\GenerateTasksEntities::class,
        ]);
        Board::observe(new UuidObserver());
        Task::observe(new UuidObserver());
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('tasks.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'tasks'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/tasks');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom([$viewPath, $sourcePath], 'tasks');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/tasks');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'tasks');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'tasks');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    public function registerMenu()
    {
        $menu = MenuPing::instance('sidebar');
        $menu->dropdown('Tareas', function ($sub) {
            $sub->route('boards.index', 'Tableros', [], 1, [
                'active' => function () {
                    $request = app('Illuminate\Http\Request');
                    return $request->is('boards*');
                }
            ]);
            $sub->route('tasks.flows.index', 'Configuración de flujos', [], 1, [
                'active' => function () {
                    $request = app('Illuminate\Http\Request');
                    return $request->is('tasks/flows*');
                }
            ])->hideWhen(function () {
                if (Auth::user()->can('config-tasks')) {
                    return false;
                }
                return true;
            });
            $sub->route('boards.config.index', 'Configuración de tableros', [], 2, [
                'active' => function () {
                    $request = app('Illuminate\Http\Request');
                    return $request->is('boards/config/*');
                }
            ])->hideWhen(function () {
                if (Auth::user()->can('config-tasks')) {
                    return false;
                }
                return true;
            });
            $sub->route('tasks.config.index', 'Configuración de tareas', [], 2, [
                'active' => function () {
                    $request = app('Illuminate\Http\Request');
                    return $request->is('tasks/config/*');
                }
            ])->hideWhen(function () {
                if (Auth::user()->can('config-tasks')) {
                    return false;
                }
                return true;
            });
        }, 3, ['icon' => 'fa fa-tasks']);
    }

}
