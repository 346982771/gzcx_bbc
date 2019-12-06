<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::any('/index/test', function() {
//    $ctrl = \App::make("\\App\\Http\\Controllers\\" . ucfirst('api') . "\\" . ucfirst('index') . "Controller");
//    return \App::call([$ctrl, ucfirst('test')]);
//});

Route::group(['namespace' => 'Api'], function (){
    //信息操作
    Route::any('/News/add','NewsController@add');
    Route::post('/News/del','NewsController@del');
    Route::get('/News/getNewsInfo','NewsController@getNewsInfo');
    Route::post('/News/getNewsList','NewsController@getNewsList');
    Route::get('/News/getNewsListAll','NewsController@getNewsListAll');
    Route::get('/News/getNewsListAll1','NewsController@getNewsListAll1');
    Route::get('/News/test','NewsController@test');
    //用户操作
    Route::get('/UserOperate/praise','UserOperateController@praise');
    Route::get('/UserOperate/cancelPraise','UserOperateController@cancelPraise');

    //常用操作
    Route::any('/Common/getUserInfo','CommonController@getUserInfo');
    Route::post('/Common/actionGetOpenid','CommonController@actionGetOpenid');
    Route::any('/Common/common','CommonController@common');

});