<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */

    private $modules = [];
    public function boot()
    {
        parent::boot();

        $this->modules = $this->app['modules'];

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        $this->loadModuleRoutes('web');


    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        $this->loadModuleRoutes('api','api');
    }

    protected function mapAdminRoutes(){
        $this->loadModuleRoutes('admin','admin');
    }

    protected function loadModuleRoutes($name,$prefix = null)
    {
        $routeConfig = [];
        if($prefix !== null ) $routeConfig['prefix'] = $prefix;

        Route::group($routeConfig,function () use ($name){
            foreach ($this->modules as $moduleName => $config){
                $path = base_path('module'.DIRECTORY_SEPARATOR.$moduleName.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.$name.'.php');
                if (file_exists($path) && ($config['auto'] || module_status($moduleName))){
                    Route::group(
                        ['namespace'=>'Module\\'.$moduleName.'\\Controllers'], $path
                    );
                }

            }
        });

    }
}
