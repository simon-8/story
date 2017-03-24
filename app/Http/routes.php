<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// 后台路由
$admin = [
    'prefix' => 'admin',
    'namespace' => 'Admin',
];
Route::group($admin , function(){

    //debug
    Route::get('form' , function(){
       return view('admin.form');
    });
    //debug

    Route::get('login' , 'AuthController@getLogin')->name('getAdminLogin');
    Route::post('login' , 'AuthController@postLogin')->name('postAdminLogin');


    Route::get('logout' , 'AuthController@getLogout')->name('getAdminLogout');
    Route::any('enterpassword' , 'AuthController@getEnterpassword')->name('getEnterpassword');

    //AdminAuthenticate中间件接管
    Route::group(['middleware' => 'admin'] ,function(){

        Route::get('/' , 'IndexController@getIndex')->name('Admin.getIndex');
        Route::any('ajax' , 'AjaxController@getIndex')->name('Admin.Ajax');

        //管理员管理
        Route::controller('manager' , 'ManagerController' , [
            'getIndex'   => 'Manager.getIndex',
            'getCreate'  => 'Manager.getCreate',
            'postCreate' => 'Manager.postCreate',
            'getUpdate'  => 'Manager.getUpdate',
            'postUpdate' => 'Manager.postUpdate',
            'getDelete'  => 'Manager.getDelete',
        ]);
        //文章管理
        Route::controller('article' , 'ArticleController' , [
            'getIndex'      => 'Article.getIndex',
            'getCreate'     => 'Article.getCreate',
            'postCreate'    => 'Article.postCreate',
            'getUpdate'     => 'Article.getUpdate',
            'postUpdate'    => 'Article.postUpdate',
            'getDelete'     => 'Article.getDelete',
            'getCategorys'  => 'Article.getCategorys',
            'getRecycle'    => 'Article.getRecycle',
        ]);
        //菜单管理
        Route::controller('menu' , 'MenuController' , [
            'getIndex'   => 'Menu.getIndex',
            'getCreate'  => 'Menu.getCreate',
            'postCreate' => 'Menu.postCreate',
            'getUpdate'  => 'Menu.getUpdate',
            'postUpdate' => 'Menu.postUpdate',
            'getDelete'  => 'Menu.getDelete',
        ]);
        //数据管理
        Route::controller('database' , 'DatabaseController' , [
            'getIndex'   => 'Database.getIndex',
            'getFields'  => 'Database.getFields',
            'getRepair'  => 'Database.getRepair',
            'getOptimize'=> 'Database.getOptimize',
        ]);
        //系统配置
        Route::controller('setting' , 'SettingController' , [
            'getIndex'   => 'Setting.getIndex',
            'postIndex'  => 'Setting.postIndex',
            'postCreate' => 'Setting.postCreate',
            'getDelete'  => 'Setting.getDelete',
            'getCollect' => 'Setting.getCollect',
        ]);
        //微信配置
        Route::controller('weixin' , 'WeixinController' , [
            'getIndex'   => 'Weixin.getIndex',
            'getUsers'   => 'Weixin.getUsers',
        ]);
        //采集配置
        Route::controller('collect' , 'CollectController' , [
            'getIndex'   => 'Collect.getIndex',
        ]);
        //小说管理
        Route::controller('book' , 'BookController' , [
            'getIndex'              => 'Book.getIndex',
            'getCreate'             => 'Book.getCreate',
            'postCreate'            => 'Book.postCreate',
            'getCreateQueue'        => 'Book.getCreateQueue',
            'getQueueNumber'        => 'Book.getQueueNumber',
            'getDetailUpdate'       => 'Book.getDetailUpdate',
//            'getUpdate'             => 'Book.getUpdate',
            'postUpdate'            => 'Book.postUpdate',
            'getDelete'             => 'Book.getDelete',
            'getCategorys'          => 'Book.getCategorys',
            'getRecycle'            => 'Book.getRecycle',
            'getDetailLists'        => 'Book.getDetailLists',
            'getDetailListsUpdate'  => 'Book.getDetailListsUpdate',
            'getDetail'             => 'Book.getDetail',
            'getUpdateDetail'       => 'Book.getUpdateDetail',
            'postUpdateDetail'      => 'Book.postUpdateDetail',
            'getDeleteDetail'       => 'Book.getDeleteDetail',//111
        ]);
    });

});

//前台模块路由
$home = [
    'prefix'    => '/',
    'namespace' => 'Home',
];
Route::group($home , function(){
    Route::controllers([
        'article'   => 'ArticleController',
        '/'         => 'IndexController'
    ]);
});

//微信路由
Route::any('/wechat', 'Wechat\ServerController@getIndex');