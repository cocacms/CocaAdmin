<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace Module\AdminBase\Middleware;
use Closure;
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