<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace Module\AdminBase\Providers\Components;

use Module\AdminBase\Models\Category;
use Closure;

class CategoryHelper
{
    protected $links = [];
    protected $hooks = [];
    public function buildTree($tag = null,$withSelf = false)
    {
        $categories = collect();

        if(is_null($tag)){
            $roots = Category::roots()->get();
            $ancestors = $roots->map(function ($root){
                $rootAndDescendants = $root->getDescendantsAndSelf();
                return $rootAndDescendants;
            });


            foreach ($ancestors as $ancestor){
                foreach ($ancestor as $item){
                    $categories->push($item);
                }
            }
        }else{
            $root = Category::where('tag','=',$tag)->firstOrFail();
            if (!$withSelf){
                $categories = $root->getDescendants();
            }else{
                $categories = $root->getDescendantsAndSelf();
            }
        }

        return $categories->map(function ($descendant){
            $descendant->tname = $descendant->name;
            if ($descendant->isRoot()){
                $descendant->name = $descendant->name.' [根域]';
                return $descendant;
            }
            $descendant->name = str_repeat('　', $descendant->depth).'∟'.$descendant->name;
            return $descendant;
        })->toArray();

    }


    public function buildTreeById($id,$withSelf = false)
    {
        $root = Category::where('id','=',$id)->firstOrFail();
        if (!$withSelf){
            $categories = $root->getDescendants();
        }else{
            $categories = $root->getDescendantsAndSelf();
        }

        return $categories->map(function ($descendant){
            $descendant->tname = $descendant->name;
            if ($descendant->isRoot()){
                $descendant->name = $descendant->name.' [根域]';
                return $descendant;
            }
            $descendant->name = str_repeat('　', $descendant->depth).'∟'.$descendant->name;
            return $descendant;
        })->toArray();

    }

    public function getIds($tag = null,$withSelf = false){
        $categories = collect();

        if(is_null($tag)){
            $roots = Category::roots()->get();
            $ancestors = $roots->map(function ($root){
                $rootAndDescendants = $root->getDescendantsAndSelf();
                return $rootAndDescendants;
            });


            foreach ($ancestors as $ancestor){
                foreach ($ancestor as $item){
                    $categories->push($item);
                }
            }
        }else{
            $root = Category::where('tag','=',$tag)->firstOrFail();
            if (!$withSelf){
                $categories = $root->getDescendants();
            }else{
                $categories = $root->getDescendantsAndSelf();
            }
        }

        return $categories->map(function ($descendant){
            return $descendant->id;
        })->toArray();
    }

    public function getIdsById($id,$withSelf = false){

        $root = Category::where('id','=',$id)->firstOrFail();
        if (!$withSelf){
            $categories = $root->getDescendants();
        }else{
            $categories = $root->getDescendantsAndSelf();
        }

        return $categories->map(function ($descendant){
            return $descendant->id;
        })->toArray();
    }

    public function registerUpdatedHook($root,Closure $closure){
        $this->hooks[$root][] = $closure;
    }

    public function handleUpdated($obj)
    {
        foreach ($this->hooks as $root => $hooks){
            $rootCategory = Category::where('tag','=',$root)->firstOrFail();
            if ($rootCategory->isSelfOrAncestorOf($obj)){
                foreach ($hooks as $hook){
                    if ($hook instanceof Closure){
                        $hook($obj);
                    }
                }
            }
        }
    }
}