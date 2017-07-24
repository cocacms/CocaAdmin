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
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Module\AdminBase\Models\Ad;

class AdController extends Controller
{

    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('ad.index');
    }

    /**
     * 获取列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list()
    {
        $data = Ad::paginate($this->pageSize)->toArray();

        $data['data'] = collect($data['data'])->map(function ($item){
            $item['script'] = str_limit(base64_decode($item['script']),200);
            return $item;
        })->toArray();
        return response()->json(success_json($data));
    }

    /**
     * 添加页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add()
    {
        return $this->view('ad.add');
    }

    /**
     * 添加数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        return $this->submit(null,$request);
    }


    /**
     * 编辑页面
     * @param $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id)
    {
        $ad = Ad::findOrFail($id);
        $ad->script = base64_decode($ad->script);
        return $this->view('ad.edit',['ad'=>$ad]);
    }


    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            Ad::destroy(array_values($data));

        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

    /**
     * 编辑数据
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit($id, Request $request)
    {
        return $this->submit($id,$request);
    }

    /**
     * 数据修改提交
     * @param null $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function submit($id =  null, Request $request)
    {
        $data = $request->only('tag','name','script','show');
        $data['script'] = base64_encode($data['script']);
        $data['show'] = is_null($data['show']) ? 0 : $data['show'];
        $data = array_value_not_null($data);
        try{
            if(is_null($id)){
                Ad::create($data);
            }else{
                $ad = Ad::findOrFail($id);
                $ad->fill($data);
                $ad->save();
            }
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }

        return response()->json(success_json());
    }

    /**
     * 修改显示隐藏
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeShow(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        $ad = Ad::findOrFail($id);
        try{
            $ad->show = $show;
            $ad->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}