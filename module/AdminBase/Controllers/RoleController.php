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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Module\AdminBase\Models\Permission;
use Module\AdminBase\Models\Role;

class RoleController extends Controller
{
    /**
     * 角色列表页
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index(){
        return $this->view('role.index');
    }

    /**
     * 获取角色列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(){
        $data = Role::all();
        return response()->json(success_json($data));
    }

    /**
     * 修改添加角色页面
     * @param null $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id = null){
        if (is_null($id)){
            $role = new Role();
        }else{
            $role = Role::findOrFail($id);
        }
        return $this->view('role.edit',[
            'role'=>$role,
            'id' => is_null($id) ? '' : $id
        ]);
    }

    /**
     * 添加修改角色数据
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request,$id = null){
        $input = $request->only('name');
        if(is_null($id)){
            $role = new Role();
        }else{
            $role = Role::findOrFail($id);
        }
        $role->name = $input['name'];
        if($role->save()){
            return response()->json(success_json());
        }else{
            return response()->json(error_json());
        }

    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        DB::beginTransaction();
        try{
            Role::destroy(array_values($data));
            Permission::whereIn('role_id',array_values($data))->delete();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(error_json($e->getMessage()));
        }
        DB::commit();
        return response()->json(success_json());
    }

    /**
     * 编辑角色权限页面
     * @param $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function editPermission($id){
        $permissions = Role::findOrFail($id)->permissions->map(function ($permission){
            return strtolower($permission->uri.'@'.$permission->method);
        })->toArray();
        $routes = Route::getRoutes()->getRoutes();
        $routeList = [];
        foreach ($routes as $route){
//            筛选权限列表
            if(!$route->autoPermission && !is_null($route->permissionName)){

                $uri = $route->uri();
                $method = $route->methods()[0];
                $permission = strtolower($uri.'@'.$method);

                $routeList[$route->groupName][] = [
                    'name'=>$route->permissionName ,
                    'uriWithMethod' => $permission ,
                    'checked' => in_array($permission,$permissions) ? true : false
                ];
            }
        }

        return $this->view('role.editPermission',['routeGroup' => $routeList,'id'=>$id]);
    }

    /**
     * 提交修改角色权限
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitPermission(Request $request,$id){
        $permissions  = array_keys($request->input('permission',[]));
        $data = [];        foreach ($permissions as $permission){
            $temp = explode('@',$permission);
            if (count($temp) >= 2){
                $data[] = [
                    'uri' => $temp[0],
                    'method' => $temp[1],
                    'role_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        DB::beginTransaction();
        try{
            Permission::where('role_id', '=', $id)->delete();
            Permission::insert($data);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(error_json($e->getMessage()));
        }
        DB::commit();
        return response()->json(success_json());
    }

}