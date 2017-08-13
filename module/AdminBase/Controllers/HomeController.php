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
use Module\AdminBase\Facades\CategoryFacade;
use Module\Shop\Models\Order;
use Module\User\Models\User;

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

        $all_count_user = User::count();
        $wait_count_order = Order::where('status','=',Order::STATUS_PAYED)->count();
        $all_count_order = Order::where('status','<>',Order::STATUS_CREATE)->count();

        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $start = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
        $end= mktime(23,59,59,$month,$day,$year);//当天结束时间戳

        $today_amount_order = Order::whereBetween('created_at',[now(null,$start),now(null,$end)])
            ->whereIn('status',[Order::STATUS_PAYED,Order::STATUS_SEND,Order::STATUS_SENDING])
            ->sum('amount');

        $all_amount_order = Order::whereIn('status',[Order::STATUS_PAYED,Order::STATUS_SEND,Order::STATUS_SENDING])
            ->sum('amount');


        return $this->view('home',[
            'new_count_user'=>\Illuminate\Support\Facades\Cache::get('user_plus_count',0),
            'all_count_user'=>$all_count_user,
            'wait_count_order'=>$wait_count_order,
            'all_count_order' => $all_count_order,
            'today_amount_order' => $today_amount_order,
            'all_amount_order' => $all_amount_order
        ]);
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
        $menu = collect($menu)->sortBy(function ($item, $key) {
            return isset($item['index']) ? $item['index'] : $key - 9999999;
        })->values();
        $menu = $menu->map(function ($item){
            if(isset($item['children']) && is_array($item['children']) && count($item['children']) > 0){
                $item['children'] = collect($item['children'])->sortBy(function ($item, $key) {
                    return isset($item['index']) ? $item['index'] : $key;
                })->values()->all();
            }
            return $item;
        })->toArray();
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
                $routerName = substr($item['href'],6,strlen($item['href']) - 7);
                $realName = "";
                $item['href'] = route_parse($routerName,$realName);
                $routerName = $realName;
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
            if(isset($item['children']) && is_array($item['children']) && count($item['children']) > 0){
                $item['children'] = $this->handleMenu($item['children'],$permissions);
                if (empty($item['children']))
                    array_splice($menu,$index,1);
            }
        }

        return array_values($menu);
    }

}