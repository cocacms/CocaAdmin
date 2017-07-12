<?php
namespace Module\AdminBase\Providers;
use Illuminate\Support\ServiceProvider;
use Module\AdminBase\Providers\Components\Hello;
use Illuminate\Contracts\View\Factory as ViewFactory;
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/5
 * Time: 12:26
 */
class ModuleProvider extends ServiceProvider
{
    public function boot(){
        //注册视图解析的目录，提供全局使用
        $factory = app(ViewFactory::class);
        if (func_num_args() === 0) {
            return $factory;
        }
        $factory->addLocation(base_path('module'.DIRECTORY_SEPARATOR.'AdminBase'.DIRECTORY_SEPARATOR.'views'));
    }

    public function register(){
        $this->app->singleton(Hello::class,function($app){
            return new Hello();
        });
    }

}