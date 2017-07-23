<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace Module\AdminBase\Controllers;


use App\Facades\Content;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * 修改系统配置页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function config(){
        return $this->view('system.config');
    }

    /**
     * 提交修改系统设置数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function submitConfig(Request $request){
        $data = $request->all();
        unset($data['webLogoFile']);
        unset($data['s']);
        unset($data['_token']);
        foreach ($data as $key=>$value){
            Content::config($key,$value);
        }
        return response()->json(success_json());
    }

}