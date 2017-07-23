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
use Module\AdminBase\Models\Category;

class CategoryController extends Controller
{
    /**
     * 列表页
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function index(){
        $roots = Category::roots()->get();
        return $this->view('category.index',['roots'=>$roots]);
    }

    /**
     * 请求列表数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function _list(Request $request){
        $rootId = $request->input('current_root',0);
        if($rootId == 0){
            $root = Category::root();
        }else{
            $root = Category::where('id','=',$rootId)->firstOrFail();
        }


        $categories = $root->getDescendants();
        foreach ($categories as $category){
            if ($category->isLeaf()){
                if ($category->parent_id == $root->id){
                    $category->name = str_repeat('<i class="layui-icon display">&#xe623;</i>', $category->depth-1).'<i class="coca-icon coca-icon-zhejiao-3 display"></i> '.$category->name;
                }else{
                    $category->name = str_repeat('<i class="layui-icon display">&#xe623;</i>', $category->depth-1).'<i class="coca-icon coca-icon-zhejiao-3"></i> '.$category->name;
                }

            }else{
                $category->name = str_repeat('<i class="layui-icon display">&#xe623;</i>', $category->depth-1).'<i class="layui-icon toggle open">&#xe625;</i> '.$category->name;
            }


        }
        return response()->json(success_json($categories));
    }

    /**
     * 添加分类页
     * @param $id 添加到的父id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function add($id){
        return $this->view('category.add',['parent_id'=>$id]);
    }

    /**
     * 创建分类
     * @param $id 父id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd($id,Request $request){
        try{
            $input = $request->only('name','tag');
            $root = Category::findOrFail($id);
            $root->children()->create($input);
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
     * 修改分类页面
     * @param $id 分类id
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function edit($id){
        $category = Category::findOrFail($id);
        $roots = Category::roots()->get();
        $ancestors = $roots->map(function ($root)use ($category){
            $rootAndDescendants = $root->getDescendantsAndSelf();
            //非本域的分类直接显示
            if($category->getRoot()->id != $root->id) return $rootAndDescendants;
            //本域 过滤自己本身与子集
            $rootAndDescendants = $rootAndDescendants->filter(function ($descendant) use ($category){
                //剔除自己本身与子集
                if ($descendant->isSelfOrDescendantOf($category)){
                    return false;
                }
                else{
                    return true;
                }
            });
            return $rootAndDescendants;
        });
        $ancestorsList = collect();
        //本域提前
        $ancestors = $ancestors->sortBy(function($ancestor)use ($category){
            if($category->getRoot()->id == $ancestor->first()->id) {
                return 0;
            }else{
                return 1;
            }
        });
        foreach ($ancestors as $ancestor){
            foreach ($ancestor as $item){
                $ancestorsList->push($item);
            }
        }
        $ancestorsList = $ancestorsList->map(function ($descendant){
            //域调整
            if ($descendant->isRoot()){
                $descendant->name = $descendant->name.' [域]';
                return $descendant;
            }
            $descendant->name = str_repeat('　', $descendant->depth).'∟'.$descendant->name;
            return $descendant;
        });

        return $this->view('category.edit',[
            'id'=>$id,
            'category'=>$category,
            'ancestors' =>$ancestorsList
        ]);
    }

    /**
     * 编辑分类
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit($id,Request $request){
        $input = $request->only('name','tag','parent_id');
        $parent = Category::findOrFail($input['parent_id']);
        $category = Category::findOrFail($id);
        if($parent->id != $category->parent_id){
            $category->makeLastChildOf($parent);
        }
        $category->name = $input['name'];
        $category->tag = $input['tag'];
        if($category->save()){
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

    /**
     * 上移分类
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function moveUp($id){
        $category = Category::findOrFail($id);
        try{
            $category->moveLeft();
        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }

    /**
     * 下移分类
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function moveDown($id){
        $category = Category::findOrFail($id);
        try{
            $category->moveRight();
        }catch (\Exception $e){
            return response()->json(error_json($e->getMessage()));
        }
        return response()->json(success_json());
    }
}