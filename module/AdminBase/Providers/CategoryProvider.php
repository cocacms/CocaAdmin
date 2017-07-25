<?php
namespace Module\AdminBase\Providers;
use Illuminate\Support\ServiceProvider;
use Module\AdminBase\Providers\Components\CategoryHelper;
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */
class CategoryProvider extends ServiceProvider
{
    public function boot(){

    }

    public function register(){
        $this->app->singleton('category_helper',function($app){
            return new CategoryHelper();
        });
    }

}