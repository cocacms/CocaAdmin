<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/8
 * Time: 12:07
 */

namespace Module\AdminBase\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function index()
    {
        return $this->view('index');
    }

    public function home(){
        return $this->view('home');
    }

    public function menu()
    {
        $menu = system_content('system_menu');
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

        $menu = $this->handlerMenu($menu,$permissions);
        return response()->json($menu);
    }

    private function handlerMenu($menu,$permissions){
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
                $item['children'] = $this->handlerMenu($item['children'],$permissions);
            }
        }

        return array_values($menu);
    }

}