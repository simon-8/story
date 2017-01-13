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

$admin = [
    'prefix' => 'admin',
    'namespace' => 'Admin',
    //'middleware'    => 'admin'
];
Route::group($admin , function(){
    Route::get('login' , 'AuthController@getLogin')->name('getAdminLogin');
    Route::post('login' , 'AuthController@postLogin')->name('postAdminLogin');
    Route::get('register' , 'AuthController@getRegister')->name('getAdminRegister');
    Route::post('register' , 'AuthController@postRegister')->name('postAdminRegister');
    Route::get('logout' , 'AuthController@getLogout')->name('getAdminLogout');
    Route::any('enterpassword' , 'AuthController@getEnterpassword')->name('enterpassword');
    //AdminAuthenticate中间件接管
    Route::group(['middleware' => 'admin'] ,function(){

        Route::get('/' , 'IndexController@getIndex')->name('getAdminIndex');
        Route::controllers([
            'article' => 'ArticleController',
            'auth'	  => 'AuthController',
            //'/'       => 'IndexController',
        ]);
    });

});

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