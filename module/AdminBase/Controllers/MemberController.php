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
use Illuminate\Support\Facades\Hash;
use Module\AdminBase\Models\Member;
use App\Service\ContentService;

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
        return redirect(route('adminLogin'));
    }

}