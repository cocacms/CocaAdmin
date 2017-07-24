<?php

if(!function_exists('hasRoutePermission'))
{
    /**
     * 验证用户是否具某个路由的权限
     * @param $route
     * @return bool
     * @throws \App\Exceptions\UndefinedRouteException
     */
    function hasRoutePermission($route){

        $allPermissionUri = [];

        if (!$route instanceof \App\Service\Route){
            $routeCollection = \Illuminate\Support\Facades\Route::getRoutes();
            $routeName = $route;
            $route = $routeCollection->getByName($route);
            if ($route == null){
                throw new \App\Exceptions\UndefinedRouteException($routeName);
            }
        }

        if($route->link !== null){
            $route = $route->link;
        }

        $uri = $route->uri();
        $methods = $route->methods();

        $user = \Illuminate\Support\Facades\Auth::user();

        //无需验证权限的直接放行
        if ($user && $route->autoPermission){
            return true;
        }
        //超级管理员不验证权限
        if($user->supper == 1){
            return true;
        }
        //获取用户的全部权限
        $roles = $user->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $permission){
                $allPermissionUri[] = strtolower($permission->uri.'@'.$permission->method);
            }
        };
        if(in_array(strtolower($uri.'@'.$methods[0]),$allPermissionUri)){
            return true;
        }else{
            return false;
        }
    }
}

if (!function_exists('dictionary')){
    function dictionary($tag = 'default'){
        $dic = \Module\AdminBase\Models\Dictionary::where('tag','=',$tag)->firstOrFail();
        $dic->content = unserialize($dic->content);
        $dic->description = base64_decode($dic->description);
        return $dic;
    }
}

if (!function_exists('ad')){
    function ad($tag = 'default'){
        $ad = \Module\AdminBase\Models\Ad::where('tag','=',$tag)->firstOrFail();
        $ad->script = base64_decode($ad->script);
        return $ad;
    }
}