<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/12
 * Time: 13:48
 */

namespace Module\AdminBase\Middlewares;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class PermissionCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route = Route::getCurrentRoute();
        if(hasRoutePermission($route)){
            return $next($request);
        }else{
            if($request->expectsJson()){
                return response()->json(error_json('你没有权限操作此资源！'));
            }else{
                return redirect(route('notPermission'));
            }
        }
    }
}