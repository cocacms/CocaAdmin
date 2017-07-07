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
use Module\AdminBase\Member;

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
        $memeber = Member::where([
            ['username','=',$data['username']],
            ['password','=',$data['password']]
        ])->first();

        if(is_null($memeber)){
            return response()->json(error_json('账户密码有误！'));
        }
        Auth::guard('admin')->login($memeber,true);
        return response()->json(success_json());
    }

}