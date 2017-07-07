<?php
namespace Module\AdminBase\Providers;
use Illuminate\Support\ServiceProvider;
use Module\AdminBase\Providers\Components\Hello;

/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/5
 * Time: 12:26
 */
class ModuleProvider extends ServiceProvider
{
    public function boot(){

    }

    public function register(){
        $this->app->singleton(Hello::class,function($app){
            return new Hello();
        });
    }

}