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
];
Route::group($admin , function(){
    Route::get('/' , 'IndexController@getIndex')->name('admin');
    Route::get('login' , 'AuthController@getLogin')->name('getLogin');
    Route::post('login' , 'AuthController@postLogin')->name('postLogin');
    Route::get('register' , 'AuthController@getRegister')->name('getRegister');
    Route::post('register' , 'AuthController@postRegister')->name('postRegister');
    Route::controllers([
    	'article' => 'ArticleController',
    	'auth'	  => 'Auth\AuthController',
    ]);
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