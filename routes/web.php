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

Route::get('/', function () {
    return view('welcome');
});

// 登陆
Route::get('/login','loginController@login')->name('login');
Route::get('/captcha','loginController@captcha')->name('captcha');
Route::post('/login','loginController@dologin')->name('dologin');
// 后台 管理
Route::get('/admin','AdminController@index')->name('admin_index');
Route::get('/home','AdminController@home')->name('admin_home');
Route::get('/istrator','AdminController@istrator')->name('administrator');
Route::get('/info','AdminController@info')->name('admin_info');
Route::post('/info','AdminController@doinfo')->name('admin_user');

// 商品
Route::get('/goods','GoodController@index')->name('goods');
Route::get('/sale_y','GoodController@sale_y')->name('goods_sale_y');
Route::get('/sale_n','GoodController@sale_n')->name('goods_sale_n');
Route::get('/good_add','GoodController@good_add')->name('goods_add');
// 分类
Route::get('/category','CategoryController@index')->name('goods_category');
Route::get('/category_add','CategoryController@add')->name('category_add');
Route::get('/category_edit','CategoryController@edit')->name('category_edit');
Route::post('/category_add','CategoryController@doadd')->name('category_doadd');
Route::post('/category_edit','CategoryController@doedit')->name('category_doedit');

