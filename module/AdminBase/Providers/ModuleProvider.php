<?php
namespace Module\AdminBase\Providers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */
class ModuleProvider extends ServiceProvider
{
    public function boot(){


        if (!file_exists(public_path('module'.DIRECTORY_SEPARATOR.'AdminBase'))) {
            link_module_asset('AdminBase');
        }
        //注册视图解析的目录，提供全局使用
        $factory = app(ViewFactory::class);
        $factory->addLocation(base_path('module'.DIRECTORY_SEPARATOR.'AdminBase'.DIRECTORY_SEPARATOR.'views'));
    }

    public function register(){
    }

}