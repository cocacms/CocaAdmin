<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/22
 * Time: 17:27
 */

namespace Module\AdminBase\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module\AdminBase\Models\Category;

class CategoryRootController extends Controller
{

    /**
     * 分类域列表页
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index(){
        return $this->view('category.root.index');
    }

    /**
     * 获取分类域列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(){
        $roots = Category::roots()->get();
        return response()->json(success_json($roots));
    }

    /**
     * 分类域添加
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add(){
        return $this->view('category.root.add');
    }

    /**
     * 创建分类域
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(Request $request){
        try{
            $input = $request->only('name','tag');
            $root = Category::create($input);
        }catch (\Exception $e){
            switch ($e->getCode()){
                case '23000':
                    return response()->json(error_json('分类标识已经存在'));
                    break;
                default:
                    return response()->json(error_json($e->getMessage()));
            }
        }
        return response()->json(success_json());

    }

    /**
     * 编辑页面
     * @param $id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id){
        $root = Category::findOrFail($id);
        return $this->view('category.root.edit',['root'=>$root]);
    }

    /**
     * 编辑分类域
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit($id,Request $request){
        $input = $request->only('name','tag','parent_id');
        $root = Category::findOrFail($id);
        $root->name = $input['name'];
        $root->tag = $input['tag'];
        if($root->save()){
            return response()->json(success_json());
        }else{
            return response()->json(error_json());
        }
    }

    /**
     * 删除分类
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function del($id){
        $category = Category::findOrFail($id);
        try{
            $category->delete();
        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}