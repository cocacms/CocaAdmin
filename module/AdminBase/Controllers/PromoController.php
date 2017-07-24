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
use Module\AdminBase\Models\Promo;

/**
 * 宣传滚动栏
 * Class PromoController
 * @package Module\AdminBase\Controllers
 */
class PromoController extends Controller
{
    /**
     * 列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('promo.index',['category'=>\dictionary('promo')]);
    }

    /**
     * 获取列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(Request $request)
    {
        $tag = $request->input('category','default');
        $data = Promo::where('tag','=',$tag)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->paginate($this->pageSize)->toArray();

        $data['data'] = collect($data['data'])->map(function ($item){
            $item['content'] = base64_decode($item['content']);
            $item['pic'] = asset($item['pic']);

            if (empty($item['description'])){
                $item['description'] = '-';
            }

            return $item;
        })->toArray();
        return response()->json(success_json($data));
    }

    /**
     * 添加页面
     * @param Request $request
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add(Request $request)
    {
        $category = $request->input('category','default');
        return $this->view('promo.add',['category'=>$category]);
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
        $promo = Promo::findOrFail($id);
        $promo->content = base64_decode($promo->content);
        return $this->view('promo.edit',['promo'=>$promo]);
    }


    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            Promo::destroy(array_values($data));

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
        $data = $request->only('tag','name','link','target','pic','description','content','show','order');
        if (is_null($data['description']) && !is_null($data['content'])){
            $data['description'] = str_limit(strip_tags($data['content']),50);
        }
        $data['content'] = base64_encode($data['content']);
        $data['show'] = is_null($data['show']) ? 0 : $data['show'];
//        if ($is_router == 'on'){
//            $data['url'] = explode('|',$data['url']);
//            $params = [];
//            if (count($data['url']) > 2){
//                foreach ($data['url'] as $index=>$item){
//                    if ($index != 0 && count($itemParams = explode('=',$item)) >= 2){
//                        $params[$itemParams[0]] = $itemParams[1];
//                    }
//                }
//            }
//            try{
//                $data['url'] = route($data['url'][0],$params);
//            }catch (\Exception $e){
//                return response()->json(error_json($e->getMessage()));
//            }
//        }
        $data = array_value_not_null($data);
        try{
            if(is_null($id)){
                Promo::create($data);
            }else{
                $promo = Promo::findOrFail($id);
                $promo->fill($data);
                $promo->save();
            }
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }

        return response()->json(success_json());
    }

    /**
     * 修改顺序
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeOrder(Request $request)
    {
        $id = $request->input('id');
        $order = $request->input('order');
        $promo = Promo::findOrFail($id);
        try{
            $promo->order = $order;
            $promo->save();
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
        $promo = Promo::findOrFail($id);
        try{
            $promo->show = $show;
            $promo->save();
        }catch (QueryException $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}