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
    'prefix' => 'pc',
    'namespace' => 'Admin',
];
Route::group($admin , function(){

    //debug
    // Route::get('form' , function(){
    //    return view('admin.form');
    // });
    //debug

    Route::get('login' , 'AuthController@getLogin')->name('getAdminLogin');
    Route::post('login' , 'AuthController@postLogin')->name('postAdminLogin');


    Route::get('logout' , 'AuthController@getLogout')->name('getAdminLogout');
    Route::any('enterpassword' , 'AuthController@getEnterpassword')->name('getEnterpassword');

    //AdminAuthenticate中间件接管
    Route::group(['middleware' => 'admin'], function () {

        Route::get('/', 'IndexController@getIndex')->name('Admin.getIndex');
        Route::post('/', 'IndexController@postIndex')->name('Admin.postIndex');
        Route::any('ajax', 'AjaxController@getIndex')->name('Admin.Ajax');

        //管理员管理
        Route::controller('manager', 'ManagerController', ['getIndex' => 'Manager.getIndex', 'getCreate' => 'Manager.getCreate', 'postCreate' => 'Manager.postCreate', 'getUpdate' => 'Manager.getUpdate', 'postUpdate' => 'Manager.postUpdate', 'getDelete' => 'Manager.getDelete',]);
        //文章管理
        Route::controller('article', 'ArticleController', ['getIndex' => 'Article.getIndex', 'getCreate' => 'Article.getCreate', 'postCreate' => 'Article.postCreate', 'getUpdate' => 'Article.getUpdate', 'postUpdate' => 'Article.postUpdate', 'getDelete' => 'Article.getDelete', 'getCategorys' => 'Article.getCategorys', 'getRecycle' => 'Article.getRecycle',]);
        //菜单管理
        Route::controller('menu', 'MenuController', ['getIndex' => 'Menu.getIndex', 'getCreate' => 'Menu.getCreate', 'postCreate' => 'Menu.postCreate', 'getUpdate' => 'Menu.getUpdate', 'postUpdate' => 'Menu.postUpdate', 'getDelete' => 'Menu.getDelete',]);
        //数据管理
        Route::controller('database', 'DatabaseController', ['getIndex' => 'Database.getIndex', 'getFields' => 'Database.getFields', 'getRepair' => 'Database.getRepair', 'getOptimize' => 'Database.getOptimize',]);
        //系统配置
        Route::controller('setting', 'SettingController', ['getIndex' => 'Setting.getIndex', 'postIndex' => 'Setting.postIndex', 'postCreate' => 'Setting.postCreate', 'getDelete' => 'Setting.getDelete', 'getCollect' => 'Setting.getCollect', 'getFriendLinks' => 'Setting.getFriendLinks', 'postFriendLinks' => 'Setting.postFriendLinks', //'getFriendLinkCreate' => 'Setting.getFriendLinkCreate',
            'getFriendLinkDelete' => 'Setting.getFriendLinkDelete', 'getImageUpload' => 'Setting.getImageUpload', 'getLinkSubmit' => 'Setting.getLinkSubmit',//'postLinkSubmit'     => 'Setting.postLinkSubmit',
        ]);
        //微信配置
        Route::controller('weixin', 'WeixinController', ['getIndex' => 'Weixin.getIndex', 'getUsers' => 'Weixin.getUsers',]);
        //采集配置
        Route::controller('collect', 'CollectController', ['getIndex' => 'Collect.getIndex',]);

        Route::group(['prefix' => 'book'], function () {
            Route::get('/', 'BookController@getIndex')->name('Book.getIndex');
            //Route::get('/create', 'BookController@getCreate')->name('Book.getCreate');
            //Route::post('/create', 'BookController@postCreate')->name('Book.postCreate');
            Route::post('/update', 'BookController@postUpdate')->name('Book.postUpdate');
            Route::get('/delete', 'BookController@getDelete')->name('Book.getDelete');
            //Route::get('/recycle', 'BookController@getRecycle')->name('Book.getRecycle');

            Route::get('/createQueue', 'BookController@createQueue')->name('Book.createQueue');
            Route::get('/updateQueue', 'BookController@updateQueue')->name('Book.updateQueue');
            Route::get('/queueNumber', 'BookController@queueNumber')->name('Book.getQueueNumber');
            Route::get('/categorys', 'BookController@getCategorys')->name('Book.getCategorys');


            Route::get('/chapters', 'BookController@getChapters')->name('Book.getChapters');
            Route::get('/updateChapters', 'BookController@updateChapters')->name('Book.updateChapters');
            Route::get('/chapterContent', 'BookController@chapterContent')->name('Book.chapterContent');
            Route::match(['get', 'post'], '/updateChapter', 'BookController@updateChapter')->name('Book.updateChapter');
            Route::get('/deleteChapter', 'BookController@deleteChapter')->name('Book.deleteChapter');
        });

        Route::group(['prefix' => 'role'], function() {
            Route::get('/', 'RoleController@getIndex')->name('Role.index');
            Route::match(['get', 'post'], '/updateAccess', 'RoleController@updateAccess')->name('Role.updateAccess');
            Route::get('/delete', 'RoleController@getDelete')->name('Role.getDelete');
        });
    });

});

//移动端模块路由
$wap = [
    //'prefix'    => '/',
    'namespace' => 'Wap',
    'domain'    => 'm.txshu.com'
];
Route::group($wap , function(){
    Route::get('xiaoshuo/{catid}.html' ,'BooksController@getIndex')->where('catid','\d+')->name('BookCat');
    Route::get('xiaoshuo/{catid}/{id}.html' ,'BooksController@getLists')->where([
        'catid' => '\d+',
        'id'    => '\d+'
    ])->name('BookLists');
    Route::get('xiaoshuo/{catid}/{id}/{aid}.html' ,'BooksController@getContent')->where([
        'catid' => '\d+',
        'id'    => '\d+',
        'aid'   => '\d+'
    ])->name('BookContent');
    Route::get('xiaoshuo/{catid}/{id}/chapter.html' ,'BooksController@getChapter')->where([
        'catid' => '\d+',
        'id'    => '\d+'
    ])->name('BookChapter');
    Route::get('xiaoshuo/{catid}/{id}/lastest.html' ,'BooksController@getLastContent')->where([
        'catid' => '\d+',
        'id'    => '\d+'
    ])->name('BookLastContent');
    Route::get('/' , 'IndexController@getIndex')->name('getHomeIndex');
    Route::get('/test' , 'IndexController@getTest');
});


//前台模块路由
$home = [
    'prefix'    => '/',
    'namespace' => 'Home',
];
Route::group($home , function(){

    Route::controllers([
        'article'   => 'ArticleController',
    ]);

    Route::get('xiaoshuo/{catid}.html' ,'BooksController@getIndex')->where('catid','\d+')->name('BookCat');
    Route::get('xiaoshuo/{catid}/{id}.html' ,'BooksController@getLists')->where([
        'catid' => '\d+',
        'id'    => '\d+'
    ])->name('BookLists');
    Route::get('xiaoshuo/{catid}/{id}/{aid}.html' ,'BooksController@getContent')->where([
        'catid' => '\d+',
        'id'    => '\d+',
        'aid'   => '\d+'
    ])->name('BookContent');
    Route::get('xiaoshuo/{catid}/{id}/lastest.html' ,'BooksController@getLastContent')->where([
        'catid' => '\d+',
        'id'    => '\d+'
    ])->name('BookLastContent');
    Route::get('/' , 'IndexController@getIndex')->name('getHomeIndex');
    Route::get('/test' , 'IndexController@getTest');
});


//微信路由
Route::any('/wechat', 'Wechat\ServerController@getIndex');