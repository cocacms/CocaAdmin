<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/7
 * Time: 21:13
 */

if(!function_exists('captcha_check'))
{
    function captcha_check($captcha)
    {
        $_captcha = session('_captcha');
        $captchaBuild = new \Gregwar\Captcha\CaptchaBuilder();
        $captchaBuild->setPhrase($_captcha);
        return $captchaBuild->testPhrase($captcha);
    }
}


if(!function_exists('error_json'))
{
    function error_json($msg = '系统发生错误！')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'data' =>[]
        ];
    }
}

if(!function_exists('success_json'))
{
    function success_json($data = [],$msg = '操作成功！')
    {
        return [
            'code' => 1,
            'msg' => $msg,
            'data' =>$data
        ];
    }
}