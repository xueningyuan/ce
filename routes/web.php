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