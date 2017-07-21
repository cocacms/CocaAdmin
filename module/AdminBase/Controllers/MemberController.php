<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/7
 * Time: 13:54
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
    public function login(){
        return $this->view('login');
    }

    public function postLogin(Request $request){
        $data = $request->all();
        if(!captcha_check($data['code'])){
            return response()->json(error_json('验证码错误！'));
        }
        $member = Member::where([
            ['username','=',$data['username']],
        ])->first();

        if(is_null($member)){
            return response()->json(error_json('账户不存在！'));
        }
        if(!Hash::check($data['password'],$member->password)){
            return response()->json(error_json('账户密码有误！'));

        }
        Auth::guard('admin')->login($member,true);
        return response()->json(success_json());
    }

    public function changeInfo(){
        return $this->view('member.changeInfo');
    }

    public function changePassword(){
        return $this->view('member.changePassword');
    }

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

    public function logout(){
        Auth::logout();
        return redirect(route('admin@login'));
    }


    public function index(Request $request){
        return $this->view('member.index');
    }

    public function _list(){
        $data = Member::paginate(20);
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

    public function edit($id = null){
        $roles = Role::all()->toArray();
        foreach ($roles as &$role){
            $role['checked'] = 0;
        }
        if (is_null($id)){
            $member = new Member();
        }else{
            $member = Member::find($id);
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
                $member = Member::find($id);
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
            DB::table('role_member_relations')->insert($data);
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