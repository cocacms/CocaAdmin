<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace Module\AdminBase\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    /**
     *  后台框架
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('index');
    }

    /**
     * 首页页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function home(){
        return $this->view('home');
    }

    /**
     * 菜单数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function menu()
    {
        $menu = get_admin_menu();
        //获取用户权限
        $member = Auth::user();
        $roles = $member->roles;
        $permissions = [];
        foreach ($roles as $role){
            $rolePermissions = $role->permissions->map(function ($item){
                return strtolower($item->uri.'@'.$item->method);
            });

            foreach ($rolePermissions as $rolePermission){
                $permissions[] = $rolePermission;
            }
        }
        $permissions = array_unique($permissions);

        $menu = $this->handleMenu($menu,$permissions);
        return response()->json($menu);
    }

    /**
     * 根据权限过滤菜单展示
     * @param $menu
     * @param $permissions
     * @return array
     */
    private function handleMenu($menu,$permissions){
        foreach ($menu as $index => &$item){
            if(stripos($item['href'],'route[') !== false){
                $routerName = str_ireplace(['route[',']'],[''],$item['href']);
                $item['href'] = route($routerName);
                if(Auth::user()->supper != 1){
                    //过滤没有权限的menu
                    $routeCollection = Route::getRoutes();
                    $route = $routeCollection->getByName($routerName);
                    $route = $route->link;
                    if($route !== null){
                        $uri = $route->uri();
                        $method = $route->methods()[0];
                        if(!in_array(strtolower($uri.'@'.$method),$permissions)){
                            array_splice($menu,$index,1);
                            continue;
                        }
                    }
                }

            }
            if(isset($item['children']) && count($item['children']) > 0){
                $item['children'] = $this->handleMenu($item['children'],$permissions);
                if (empty($item['children']))
                    array_splice($menu,$index,1);
            }
        }

        return array_values($menu);
    }

}