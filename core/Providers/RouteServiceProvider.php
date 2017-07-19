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
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        //读取模块
        $current_dir = opendir(base_path('module'));
        while(($file = readdir($current_dir)) !== false) {
            if ( $file != '.' && $file != '..')
            {
                $cur_path = base_path('module'.DIRECTORY_SEPARATOR.$file);
                if ( is_dir ( $cur_path ))
                {
                    $this->modules[] = $file;
                }
            }
        }
        closedir($current_dir);

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();

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
//        Route::prefix('api')
//            ->middleware('api')
//            ->namespace($this->namespace)
//            ->group(base_path('routes/api.php'));
    }

    protected function mapAdminRoutes(){
        $this->loadModuleRoutes('admin','admin');
    }

    protected function loadModuleRoutes($name,$prefix = null)
    {
        $routeConfig = [];
        if($prefix !== null ) $routeConfig['prefix'] = $prefix;

        Route::group($routeConfig,function () use ($name){
            foreach ($this->modules as $module){
                if(file_exists(base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.$name.'.php'))){
                    Route::group(
                        ['namespace'=>'Module\\'.$module.'\\Controllers'],
                        base_path('module'.DIRECTORY_SEPARATOR.$module.DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.$name.'.php')
                    );

                }
            }
        });

    }
}
