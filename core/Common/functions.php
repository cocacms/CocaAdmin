<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/7
 * Time: 21:13
 */

if(!function_exists('captcha_check'))
{
    function captcha_check($captcha)
    {
        $_captcha = session('_captcha');
        $captchaBuild = new \Gregwar\Captcha\CaptchaBuilder();
        $captchaBuild->setPhrase($_captcha);
        return $captchaBuild->testPhrase($captcha);
    }
}


if(!function_exists('error_json'))
{
    function error_json($msg = '系统发生错误！')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'data' =>[]
        ];
    }
}

if(!function_exists('success_json'))
{
    function success_json($data = [],$msg = '操作成功！')
    {
        return [
            'code' => 1,
            'msg' => $msg,
            'data' =>$data
        ];
    }
}

if(!function_exists('get_current_module'))
{
    function get_current_module()
    {
        $content = app(App\Service\ContentService::class);
        return $content->get('currentModule');
    }
}


if(!function_exists('system_config'))
{
    function system_config(...$params)
    {
        $content = app(App\Service\ContentService::class);
        return $content->config(...$params);
    }
}


if(!function_exists('system_content'))
{
    function system_content(...$params)
    {
        $content = app(App\Service\ContentService::class);
        if(count($params) == 2){
            $content->set($params[0],$params[1]);
            return true;
        }else{
            return $content->get($params[0]);
        }
    }
}
if(!function_exists('now'))
{
    function now($format = null,$time = null){
        $time = $time === null ? time() : $time;
        $format = $format === null ? 'Y-m-d H:i:s' : $format;
        return date($format,time());
    }
}

if(!function_exists('hasRoutePermission'))
{
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
