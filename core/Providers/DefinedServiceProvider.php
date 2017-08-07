<?php
/**
 * Coca-Admin is a general modular web framework developed based on Laravel 5.4 .
 * Author:     Rojer
 * Mail:       rojerchen@qq.com
 * Git:        https://github.com/rojer95/CocaAdmin
 * QQ Group:   647229346
 */

namespace App\Providers;


use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


class DefinedServiceProvider extends ServiceProvider
{

    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        Route::group(['middleware' => 'web'],function (){
            //验证码模块
            Route::get('/captcha','DefinedController@captcha')->name('captcha');
        });

        //上传模块
        Route::post('/upload','DefinedController@upload')->name('webUpload');

        Route::get('/notFound','DefinedController@notFound')->name('notFound');

        Route::get('/notPermission','DefinedController@notPermission')->name('notPermission');

    }
}