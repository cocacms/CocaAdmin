<?php

namespace App\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Routing\Router;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];


    public function __construct(Application $app, Router $router)
    {
        //load module middleware
        $modules = [];
        $current_dir = opendir(base_path('module'));
        while(($file = readdir($current_dir)) !== false) {
            if ( $file != '.' && $file != '..')
            {
                $cur_path = base_path('module'.DIRECTORY_SEPARATOR.$file);
                if ( is_dir ( $cur_path ))
                {
                    $modules[] = $file;
                }
            }
        }
        closedir($current_dir);
        foreach ($modules as $module){
            $moduleMiddlewareClassName =  '\\Module\\'.$module.'\\ModuleMiddlewares';
            $moduleMiddlewareClass = new $moduleMiddlewareClassName;
            $this->middleware = array_merge($this->middleware,$moduleMiddlewareClass->getMiddleware());
            $this->middlewareGroups = array_merge($this->middlewareGroups,$moduleMiddlewareClass->getMiddlewareGroups());
            $this->routeMiddleware = array_merge($this->routeMiddleware,$moduleMiddlewareClass->getRouteMiddleware());

        }
        parent::__construct($app, $router);
    }
}
