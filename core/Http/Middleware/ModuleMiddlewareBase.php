<?php
namespace App\Http\Middleware;
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/6
 * Time: 20:34
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