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
    Route::get('/' , 'IndexController@getIndex');
    Route::controllers([
//        '/' => 'IndexController',
    ]);
});