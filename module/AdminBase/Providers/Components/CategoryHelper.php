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

class CategoryHelper
{
    protected $links = [];
    public function buildTree($tag,$withSelf = false)
    {
        $root = Category::where('tag','=',$tag)->firstOrFail();
        if ($withSelf){
            $categories = $root->getDescendants();
        }else{
            $categories = $root->getDescendantsAndSelf();
        }
        return $categories->map(function ($descendant){
            if ($descendant->isRoot()){
                $descendant->name = $descendant->name.' [域]';
                return $descendant;
            }
            $descendant->name = str_repeat('　', $descendant->depth).'∟'.$descendant->name;
            return $descendant;
        })->toArray();

    }

    public function register(\Closure $closure){
        $this->links[] = $closure;
    }

    public function allLink(){
        $links = [];
        foreach ($this->links as $closure){
            $links[] = $closure();
        }
        return $links;
    }
}