<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Route::get('/test', function () {
//    return view('admin.test.index');
//});
Route::group(['namespace' => 'Admin'], function()
{
    Route::group(['middleware' => ['web','adminAuth']],function(){
        //用户管理
        Route::any('/admin/admin/index', 'AdminController@index');
        Route::post('/admin/admin/del', 'AdminController@del');
        Route::any('/admin/admin/edit', 'AdminController@edit');
        Route::any('/admin/admin/add', 'AdminController@add');
        //权限管理
        Route::any('/admin/AuthRule/index', 'AuthRuleController@index');
        Route::post('/admin/AuthRule/menuStatus', 'AuthRuleController@menuStatus');
        Route::post('/admin/AuthRule/authOpen', 'AuthRuleController@authOpen');
        Route::post('/admin/AuthRule/sort', 'AuthRuleController@sort');
        Route::any('/admin/AuthRule/add', 'AuthRuleController@add');
        Route::any('/admin/AuthRule/edit', 'AuthRuleController@edit');
        Route::post('/admin/AuthRule/del', 'AuthRuleController@del');
        //角色管理
        Route::any('/admin/AuthGroup/index', 'AuthGroupController@index');
        Route::any('/admin/AuthGroup/add', 'AuthGroupController@add');
        Route::any('/admin/AuthGroup/edit', 'AuthGroupController@edit');
        Route::post('/admin/AuthGroup/del', 'AuthGroupController@del');
        Route::any('/admin/AuthGroup/groupAccess', 'AuthGroupController@groupAccess');
        //参数管理
//        Route::any('/admin/CarParam/index', 'CarParamController@index');
//        Route::any('/admin/CarParam/add', 'CarParamController@add');
//        Route::any('/admin/CarParam/edit', 'CarParamController@edit');
//        Route::post('/admin/CarParam/del', 'CarParamController@del');
//        Route::post('/admin/CarParam/hide', 'CarParamController@hide');
//        Route::post('/admin/CarParam/sort', 'CarParamController@sort');
//        Route::post('/admin/CarParam/isShow', 'CarParamController@isShow');
//        Route::post('/admin/CarParam/isBasis', 'CarParamController@isBasis');
        //颜色管理
//        Route::any('/admin/CarColor/index', 'CarColorController@index');
//        Route::any('/admin/CarColor/add', 'CarColorController@add');
//        Route::any('/admin/CarColor/edit', 'CarColorController@edit');
//        Route::post('/admin/CarColor/del', 'CarColorController@del');
//        Route::post('/admin/CarColor/hide', 'CarColorController@hide');
//        Route::post('/admin/CarColor/sort', 'CarColorController@sort');
        //车型管理
        Route::any('/admin/CarType/index', 'CarTypeController@index');
        Route::any('/admin/CarType/add', 'CarTypeController@add');
        Route::any('/admin/CarType/edit', 'CarTypeController@edit');
        Route::post('/admin/CarType/del', 'CarTypeController@del');
        Route::post('/admin/CarType/hide', 'CarTypeController@hide');
        Route::post('/admin/CarType/recommend', 'CarTypeController@recommend');
        //车品牌管理
        Route::any('/admin/CarBrand/index', 'CarBrandController@index');
        Route::any('/admin/CarBrand/add', 'CarBrandController@add');
        Route::any('/admin/CarBrand/edit', 'CarBrandController@edit');
        Route::post('/admin/CarBrand/del', 'CarBrandController@del');
        Route::post('/admin/CarBrand/hide', 'CarBrandController@hide');
        Route::post('/admin/CarBrand/recommend', 'CarBrandController@recommend');
        Route::post('/admin/CarBrand/sort', 'CarBrandController@sort');
        //车型管理
        Route::any('/admin/CarSeries/index', 'CarSeriesController@index');
        Route::any('/admin/CarSeries/add', 'CarSeriesController@add');
        Route::any('/admin/CarSeries/edit', 'CarSeriesController@edit');
        Route::post('/admin/CarSeries/del', 'CarSeriesController@del');
        Route::post('/admin/CarSeries/hide', 'CarSeriesController@hide');
        Route::post('/admin/CarSeries/recommend', 'CarSeriesController@recommend');
        Route::post('/admin/CarSeries/sort', 'CarSeriesController@sort');
        //新闻管理
        Route::any('/admin/News/index', 'NewsController@index');
        Route::any('/admin/News/add', 'NewsController@add');
        Route::any('/admin/News/edit', 'NewsController@edit');
        Route::post('/admin/News/del', 'NewsController@del');
        Route::post('/admin/News/hide', 'NewsController@hide');
        Route::post('/admin/News/isDraft', 'NewsController@isDraft');
        Route::post('/admin/News/getNewsTopicList', 'NewsController@getNewsTopicList');
        Route::post('/admin/News/status', 'NewsController@status');
        Route::any('/admin/News/detail', 'NewsController@detail');
        Route::post('/admin/News/topping', 'NewsController@topping');
        //话题管理
        Route::any('/admin/Topic/add', 'TopicController@add');
        Route::any('/admin/Topic/edit', 'TopicController@edit');
        Route::any('/admin/Topic/index', 'TopicController@index');
        Route::post('/admin/Topic/newsFormAdd', 'TopicController@newsFormAdd');
        Route::post('/admin/Topic/del', 'TopicController@del');
        Route::post('/admin/Topic/getTopicList', 'TopicController@getTopicList');
        //车管理
        Route::any('/admin/Car/index', 'CarController@index');
        Route::any('/admin/Car/add', 'CarController@add');
        Route::any('/admin/Car/edit', 'CarController@edit');
        Route::post('/admin/Car/del', 'CarController@del');
        Route::post('/admin/Car/hide', 'CarController@hide');
        Route::post('/admin/Car/sort', 'CarController@sort');
        Route::any('/admin/Car/addParam', 'CarController@addParam');
        Route::any('/admin/Car/getInfo', 'CarController@getInfo');

        //评论管理
        Route::any('/admin/Comment/index', 'CommentController@index');
        Route::any('/admin/Comment/edit', 'CommentController@edit');
        Route::post('/admin/Comment/del', 'CommentController@del');
        Route::post('/admin/Comment/hide', 'CommentController@hide');
        Route::any('/admin/Comment/detail', 'CommentController@detail');

        //选配包管理
        Route::any('/admin/CarOptionalPackage/index', 'CarOptionalPackageController@index');
        Route::any('/admin/CarOptionalPackage/add', 'CarOptionalPackageController@add');
        Route::any('/admin/CarOptionalPackage/edit', 'CarOptionalPackageController@edit');
        Route::post('/admin/CarOptionalPackage/del', 'CarOptionalPackageController@del');
        Route::post('/admin/CarOptionalPackage/hide', 'CarOptionalPackageController@hide');
        Route::post('/admin/CarOptionalPackage/sort', 'CarOptionalPackageController@sort');
        //用户管理
        Route::any('/admin/User/index', 'UserController@index');
        Route::post('/admin/User/pass', 'UserController@pass');
        Route::post('/admin/User/level', 'UserController@level');
        //上传
        Route::any('/admin/UpFile/upload', 'UpFileController@upload');
    });
    //登陆和首页
    Route::get('/admin/index/index', 'IndexController@index');
    Route::get('/admin/index/main', 'IndexController@main');
    Route::any('/admin/login/index', 'LoginController@index');
    Route::any('/', 'LoginController@index');
    Route::any('/admin/login/delCache', 'LoginController@delCache');

});

