<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/12
 * Time: 18:12
 */

namespace Module\AdminBase\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Module\AdminBase\Models\Role;

class RoleController extends Controller
{
    public function index(){
        return $this->view('role.index');
    }

    public function edit(Request $request,$id = null){
        if (is_null($id)){
            $role = new Role();
        }else{
            $role = Role::find($id);
        }
        return $this->view('role.edit',[
            'role'=>$role
        ]);
    }

    public function _list(){
        $data = Role::all();
        return response()->json(success_json($data));
    }

    public function submit(Request $request,$id = null){
        $input = $request->only('name');
        if(is_null($id)){
            $role = new Role();
        }else{
            $role = Role::find($id);
        }
        $role->name = $input['name'];
        if($role->save()){
            return response()->json(success_json());
        }else{
            return response()->json(error_json());
        }

    }

    public function del(Request $request){
        $data = $request->input('ids',array());
        if(Role::destroy(array_values($data)) > 0){
            return response()->json(success_json());
        }else{
            return response()->json(error_json());
        }
    }

    public function editPermission($id){
        $permissions = Role::find($id)->permissions->map(function ($permission){
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

        return $this->view('role.editPermission',['routeGroup' => $routeList]);
    }

    public function submitPermission(Request $request,$id){
        $permissions  = array_keys($request->input('permission',[]));
        $data = [];
        foreach ($permissions as $permission){
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
            Db::table('permissions')->where('role_id', '=', $id)->delete();
            DB::table('permissions')->insert($data);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(error_json($e->getMessage()));
        }
        DB::commit();
        return response()->json(success_json());
    }

}