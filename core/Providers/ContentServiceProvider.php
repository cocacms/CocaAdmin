<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/8
 * Time: 14:13
 */

namespace App\Providers;


use App\Service\ContentService;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->singleton(ContentService::class,function($app){
            return new ContentService;
        });
    }

}