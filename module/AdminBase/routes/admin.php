<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2017/7/6
 * Time: 20:03
 */
Route::group(['middleware'=>'web'],function(){
    Route::middleware(['auth:admin'])->get('/', 'TestController@test');

    Route::get('/login','MemberController@login')->name('adminLogin');
    Route::post('/login','MemberController@postLogin');
});
