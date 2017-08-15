<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Http\Controllers;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DefinedController extends Controller
{

    function captcha (Request $request){
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder((new PhraseBuilder())->build(4, 'ABDEFHJKMPT123456789'));
        //可以设置图片宽高及字体
        $builder->build($request->input('w',100), $request->input('h',40));
        //获取验证码的内容
        $phrase = $builder->getPhrase();
        //把内容存入session
        session()->flash('_captcha',$phrase);
        //生成图片
        return (new Response($builder->output(), 200))
            ->header('Content-Type', 'image/jpeg')
            ->header('Cache-Control', 'no-cache, must-revalidate');
    }

    function upload(Request $request){
        $name = $request->input('name','file');
        $tempName = $request->input('temp',null);
        $moduleName = $request->input('module',null);
        $file = $request->file($name,null);
        try{
            if(is_null($file)){
                $result = error_json('没有获取到上传的文件！',1,'');
            }else{
                $path = $file->store('uploads/'.now('Ymd'),'public');
                $result = success_json(Storage::url($path));
            }
        }catch (\Exception $e){
            $result = error_json($e->getMessage(),1,'');
        }

        if(!is_null($tempName) && !is_null($moduleName)){
            $temp = module_temp_json($moduleName,$tempName,$result);
            if($temp !== null) $result = is_string($temp) ? json_decode($temp,true) : $temp;
        }
        return response()->json($result);

    }

    public function notFound()
    {
        return view('errors.404');

    }

    public function notPermission()
    {
        return view('errors.401');

    }

    public function error($msg)
    {
        return view('errors.500',[
            'msg'=>$msg
        ]);

    }
}