<?php
namespace App\Http\Middleware;
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */
trait ModuleMiddlewareBase
{
    public function getMiddleware(){
        return $this->middleware;
    }

    public function getMiddlewareGroups(){
        return $this->middlewareGroups;
    }

    public function getRouteMiddleware(){
        return $this->routeMiddleware;
    }
}