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

class ModuleController extends Controller
{

    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('module.index');
    }

    /**
     * 获取列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list()
    {
        $data = app('modules')->map(function ($module, $key){
            $module['status'] = module_status($key);
            $module['id'] = $key;
            return $module;
        });
        return response()->json(success_json(array_values($data->toArray())));
    }

    /**
     * 修改状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request)
    {
        $name = $request->input('id','AdminBase');
        $show = $request->input('show');
        module_status($name,$show);
        return response()->json(success_json());
    }
}