<?php
namespace Module\AdminBase;

use App\Http\Middleware\ModuleMiddlewareBase;
use Module\AdminBase\Middleware\MemberToViewMiddleware;
use Module\AdminBase\Middleware\PermissionCheckMiddleware;

class ModuleMiddlewares
{
    use ModuleMiddlewareBase;
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [

    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web'=>[
            MemberToViewMiddleware::class
        ],
        'coca-admin-check' =>[
            'web',
            'auth:admin',
            'permission',
        ]

    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'permission'=>PermissionCheckMiddleware::class
    ];

}