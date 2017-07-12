<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/6
 * Time: 20:03
 */
Route::group(['middleware'=>'web'],function(){
    Route::group(['middleware'=>'auth:admin'],function (){
        Route::get('/', 'HomeController@index');
        Route::get('/menu', 'HomeController@menu');
        Route::get('/home', 'HomeController@home')->name('home');
        Route::group(['prefix'=>'user'],function (){
            Route::get('/changeInfo','MemberController@changeInfo')->name('changeInfo');
            Route::get('/changePassword','MemberController@changePassword')->name('changePassword');
            Route::get('/logout','MemberController@logout')->name('logout');
            Route::post('/submitInfo','MemberController@submitInfo');
            Route::post('/submitPassword','MemberController@submitPassword');
        });

        Route::group(['prefix'=>'system'],function (){
            Route::get('/config','SystemController@config')->name('config');
            Route::post('/submitConfig','SystemController@submitConfig');

        });
    });

    Route::get('/login','MemberController@login')->name('adminLogin');
    Route::post('/login','MemberController@postLogin');
});
