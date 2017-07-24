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
use Module\AdminBase\Models\Dictionary;

class DictionaryController extends Controller
{
    /**
     * 数据字典列表页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index()
    {
        return $this->view('dictionary.index');
    }

    /**
     * 获取数据字典列表数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list()
    {
        $data = Dictionary::paginate($this->pageSize)->toArray();
        $data['data'] = collect($data['data'])->map(function ($item){
            $item['content'] = '';
            if (is_null($item['description'])){
                $item['description'] = '-';
            }else{
                $item['description'] = str_limit(strip_tags(base64_decode($item['description'])),80);
            }
            return $item;
        });

        return response()->json(success_json($data));
    }

    /**
     * 数据字典修改提交
     * @param null $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function submit($id =  null, Request $request)
    {
        if (is_null($id)){
            $dictionary = new Dictionary();
        }else{
            $dictionary = Dictionary::findOrFail($id);
        }
        $input = $request->only('name','tag','description');
        $input['content'] = array_values($request->input('content',[]));
        $content = [];
        foreach ($input['content'] as $contentItem){
            $content[$contentItem['k']] = $contentItem['v'];
        }
        $input['content'] = serialize($content);
        $dictionary->name = $input['name'];
        $dictionary->tag = $input['tag'];
        $dictionary->description = base64_encode($input['description']);
        $dictionary->content = $input['content'];
        try{
            if($dictionary->save()){
                return response()->json(success_json());
            }
        }catch (QueryException $exception){
            switch ($exception->getCode()){
                case '23000':
                    return response()->json(error_json('标识已经存在'));
                    break;
                default:
                    return response()->json(error_json($exception->getMessage()));
            }
        }
        return response()->json(error_json());
    }



    /**
     * 添加数据字典的页面
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add()
    {
        return $this->view('dictionary.add');
    }

    /**
     * 添加数据字典
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request)
    {
        return $this->submit(null,$request);
    }

    /**
     * 编辑数据字典页面
     * @param $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id)
    {
        $dictionary = Dictionary::findOrFail($id);
        $content = unserialize($dictionary->content);
        $newContent = [];
        foreach ($content as $k => $v){
            $newContent[] = [
                'k'=>$k,
                'v'=>$v
            ];
        }
        $dictionary->content = $newContent;
        $dictionary->description = $dictionary->description == null ? '' : base64_decode($dictionary->description);
        return $this->view('dictionary.edit',['dictionary'=>$dictionary]);
    }

    /**
     * 编辑数据字典
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit($id, Request $request)
    {
        return $this->submit($id,$request);
    }

    /**
     * 删除数据字典
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function del(Request $request){
        $data = $request->input('ids',array());
        try{
            Dictionary::destroy(array_values($data));

        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

}