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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Module\AdminBase\Models\Member;
use App\Service\ContentService;
use Module\AdminBase\Models\Role;
use Module\AdminBase\Models\RoleMemberRelation;

class MemberController extends Controller
{
    /**
     * 登录页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function login(){
        return $this->view('login');
    }

    /**
     * 登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postLogin(Request $request){
        $data = $request->all();
        if(!captcha_check($data['code'])){
            return response()->json(error_json('验证码错误！'));
        }
        $member = Member::where([
            ['username','=',$data['username']],
        ])->firstOrFail();

        if(is_null($member)){
            return response()->json(error_json('账户不存在！'));
        }
        if(!Hash::check($data['password'],$member->password)){
            return response()->json(error_json('账户密码有误！'));

        }
        Auth::guard('admin')->login($member,true);
        return response()->json(success_json());
    }

    /**
     * 修改信息页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function changeInfo(){
        return $this->view('member.changeInfo');
    }

    /**
     * 修改密码页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function changePassword(){
        return $this->view('member.changePassword');
    }

    /**
     * 修改用户数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitInfo(Request $request){
        $data = $request->all();
        $member = Auth::user();
        $member->avatar = $data['avatar'];
        $member->nickname = $data['nickname'];
        $member->birthday = $data['birthday'];
        $member->sex = $data['sex'];
        $member->tel = $data['tel'];
        $member->mail = $data['mail'];
        if($member->save()){
            return response()->json(success_json());
        }else{
            return response()->json(error_json());
        }
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitPassword(Request $request){
        $data = $request->all();
        $member = Auth::user();

        if(!Hash::check($data['password'],$member->password)){
            return response()->json(error_json('密码错误！'));
        }
        $member->password = Hash::make($data['newPassword']);
        if($member->save()){
            return response()->json(success_json());
        }else{
            return response()->json(error_json('修改密码失败！'));
        }
    }

    /**
     * 登出
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(){
        Auth::logout();
        return redirect(route('admin@login'));
    }


    /**
     * 以下是管理员账户管理的控制器
     */


    /**
     * 管理员管理页面
     * @param Request $request
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index(Request $request){
        return $this->view('member.index');
    }

    /**
     * 获取管理员列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(){
        $data = Member::paginate($this->pageSize);
        $data = $data->toArray();
        $data['data'] = collect($data['data'])->map(function ($item){
            $item['avatar'] = asset($item['avatar']);
            switch ($item['sex']){
                case 1:
                    $item['sex'] = '男';
                    break;
                case 2:
                    $item['sex'] = '女';
                    break;
                default:
                    $item['sex'] = '保密';
            }
            return $item;
        });
        return response()->json(success_json($data));
    }

    /**
     * 修改添加管理员页面
     * @param null $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id = null){
        $roles = Role::all()->toArray();
        foreach ($roles as &$role){
            $role['checked'] = 0;
        }
        if (is_null($id)){
            $member = new Member();
        }else{
            $member = Member::findOrFail($id);
            $relations = RoleMemberRelation::where('member_id','=',$id)->get();
            foreach ($relations as $relation){
                foreach ($roles as &$role){
                    if($role['id'] == $relation->role_id){
                        $role['checked'] = 1;
                    }
                }
            }
        }
        return $this->view('member.edit',[
            'member'=>$member,
            'id' => is_null($id) ? '' : $id,
            'roles' =>$roles
        ]);
    }

    /**
     * 修改添加管理员
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request,$id = null){
        $input = $request->only('username','password','avatar','nickname','sex','tel','birthday','mail');
        $roles = array_keys($request->input('role',[]));

        DB::beginTransaction();
        try{
            if(is_null($id)){
                $input['password'] = Hash::make($input['password']);
                $member = Member::create($input);
                $id = $member->id;
            }else{
                unset($input['username']);
                if(!empty(trim($input['password']))){
                    $input['password'] = Hash::make($input['password']);
                }else{
                    unset($input['password']);
                }
                $member = Member::findOrFail($id);
                $member->update($input);

            }

            RoleMemberRelation::where('member_id','=',$id)->delete();
            $data = [];
            foreach ($roles as $role){
                $data[] = [
                    'member_id'=>$id,
                    'role_id'=>$role
                ];
            }
            RoleMemberRelation::insert($data);
        }catch (\Exception $e){
            DB::rollBack();
            switch ($e->getCode()){
                case '23000':
                    return response()->json(error_json('账号已经存在'));
                    break;
                default:
                    return response()->json(error_json($e->getMessage()));
            }
        }
        DB::commit();
        return response()->json(success_json());
    }

    /**
     * 删除管理员
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        DB::beginTransaction();
        try{
            Member::destroy(array_values($data));
            RoleMemberRelation::whereIn('member_id',array_values($data))->delete();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(error_json($e->getMessage()));
        }
        DB::commit();
        return response()->json(success_json());
    }

}