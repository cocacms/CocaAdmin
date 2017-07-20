<?php
Route::group(['middleware'=>'web'],function(){
    Route::group(['middleware'=>'coca-admin-check'],function (){

        Route::get('/', 'HomeController@index')->autoPermission();
        Route::get('/menu', 'HomeController@menu')->autoPermission();
        Route::get('/home', 'HomeController@home')->name('home')->autoPermission();

        Route::group(['prefix'=>'user'],function (){
            Route::get('/changeInfo','MemberController@changeInfo')->name('changeInfo')->autoPermission();
            Route::get('/changePassword','MemberController@changePassword')->name('changePassword')->autoPermission();
            Route::get('/logout','MemberController@logout')->name('logout')->autoPermission();
            Route::post('/submitInfo','MemberController@submitInfo')->autoPermission();
            Route::post('/submitPassword','MemberController@submitPassword')->autoPermission();
        },'用户设置');

        Route::group(['prefix'=>'system'],function (){
            Route::post('/submitConfig','SystemController@submitConfig')->name('system@SubmitConfig')->permissionName('设置系统基本信息');
            Route::get('/config','SystemController@config')->name('system@config')->link('system@SubmitConfig');
        },'系统设置');


        Route::group(['prefix'=>'role'],function (){
            Route::get('/list','RoleController@_list')->name('role@list')->permissionName('获取角色列表');
            Route::get('/','RoleController@index')->name('role@index')->link('role@list');

            Route::post('/edit/{id?}','RoleController@submit')->name('role@submit')->permissionName('编辑创建角色');
            Route::get('/edit/{id?}','RoleController@edit')->name('role@edit')->link('role@submit');

            Route::post('/editPermission/{id}','RoleController@submitPermission')->name('role@submitPermission')->permissionName('编辑角色权限');
            Route::get('/editPermission/{id}','RoleController@editPermission')->name('role@permissionEdit')->link('role@submitPermission');

            Route::delete('/del','RoleController@del')->name('role@del')->permissionName('删除角色');

        },'角色设置');

        Route::group(['prefix'=>'member'],function (){
            Route::get('/list','MemberController@_list')->name('member@list')->permissionName('获取管理员列表');
            Route::get('/','MemberController@index')->name('member@index')->link('member@list');

            Route::post('/edit/{id?}','MemberController@submit')->name('member@submit')->permissionName('编辑创建管理员');
            Route::get('/edit/{id?}','MemberController@edit')->name('member@edit')->link('member@submit');

            Route::delete('/del','MemberController@del')->name('member@del')->permissionName('删除用户');

        },'管理员管理');
    });

    Route::get('/login','MemberController@login')->name('admin@login');
    Route::post('/login','MemberController@postLogin');
});


/**
 * function autoPermission 登录用户就有权限
 * function link 展示页面所关联的权限 参数填关联的route的name
 * function permissionName 权限名称
 */