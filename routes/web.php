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
Route::middleware(['system'])->group(function(){
    Route::get('/istrator','AdminController@istrator')->name('administrator');
    Route::get('/admin_type','AdminController@admin_type')->name('admin_type');
    Route::post('/admin_doadd','AdminController@admin_doadd')->name('admin_doadd');
    Route::get('/admin_edit/{id}','AdminController@admin_edit')->name('admin_edit');
    Route::post('/admin_doedit/{id}','AdminController@admin_doedit')->name('admin_doedit');
    Route::get('/admin_del','AdminController@admin_del')->name('admin_del');
    
    
    Route::get('/info','AdminController@info')->name('admin_info');
    Route::post('/info','AdminController@doinfo')->name('admin_user');
    Route::get('/role','AdminController@role')->name('admin_role');
    
    Route::get('/privilege','AdminController@privilege')->name('admin_privilege');
    Route::get('/privilege_add','AdminController@privilege_add')->name('privilege_add');
    Route::post('/privilege_doadd','AdminController@privilege_doadd')->name('privilege_doadd');
    Route::get('/privilege_edit/{id}','AdminController@privilege_edit')->name('privilege_edit');
    Route::post('/privilege_doedit/{id}','AdminController@privilege_doedit')->name('privilege_doedit');
    Route::get('/privilege_del','AdminController@privilege_del')->name('privilege_del');
    
    Route::get('/role_add','AdminController@role_add')->name('role_add');
    Route::post('/role_doadd','AdminController@role_doadd')->name('role_doadd');
    Route::get('/role_edit/{id}','AdminController@role_edit')->name('role_edit');
    Route::post('/role_doedit/{id}','AdminController@role_doedit')->name('role_doedit');
    Route::get('/role_del','AdminController@role_del')->name('role_del');
    
    
    // 商品
    Route::get('/goods','GoodController@index')->name('goods');
    Route::post('/goods','GoodController@index')->name('good');
    Route::get('/goods_sku/{id}','GoodController@goods_sku')->name('goods_sku');
    Route::get('/sale_y','GoodController@sale_y')->name('goods_sale_y');
    Route::get('/sale_n','GoodController@sale_n')->name('goods_sale_n');
    Route::get('/good_add','GoodController@good_add')->name('goods_add');
    Route::post('/good_add','GoodController@good_doadd')->name('goods_doadd');
    Route::get('/ajax_get_cat','GoodController@ajax_get_cat')->name('ajax_get_cat');
    Route::get('/goods_edit/{id}','GoodController@goods_edit')->name('goods_edit');
    Route::post('/goods_edit/{id}','GoodController@goods_doedit')->name('goods_doedit');
    Route::get('/goods_del','GoodController@goods_del')->name('goods_del');
    Route::get('/sku_add/{id}','GoodController@sku_add')->name('sku_add');
    Route::post('/sku_doadd/{id}','GoodController@sku_doadd')->name('sku_doadd');
    Route::get('/sku_edit/{id}/{skuid}','GoodController@sku_edit')->name('sku_edit');
    Route::post('/sku_doedit/{id}/{skuid}','GoodController@sku_doedit')->name('sku_doedit');
    Route::get('/sku_del','GoodController@sku_del')->name('sku_del');
    
    
    
    // 分类
    Route::get('/category','CategoryController@index')->name('goods_category');
    Route::get('/category_add','CategoryController@add')->name('category_add');
    Route::get('/category_edit','CategoryController@edit')->name('category_edit');
    Route::get('/category_del','CategoryController@del')->name('category_del');
    Route::post('/category_add','CategoryController@doadd')->name('category_doadd');
    Route::post('/category_edit','CategoryController@doedit')->name('category_doedit');
    Route::post('/category_del','CategoryController@dodel')->name('category_dodel');
    
    // 订单
    Route::get('/Order_transaction','OrderController@order_transaction')->name('order_transaction');
    Route::get('/Order_handling','OrderController@Order_handling')->name('Order_handling');
    Route::get('/Order_refund','OrderController@Order_refund')->name('Order_refund');
    Route::get('/Order_type','OrderController@Order_type')->name('Order_type');
    Route::get('/Order_detailed','OrderController@Order_detailed')->name('Order_detailed');
    
    // 用户
    Route::get('/user','UserController@user')->name('user');
    Route::get('/user_typr','UserController@user_typr')->name('user_typr');
    Route::get('/user_del','UserController@user_del')->name('user_del');
    // 等级
    Route::get('/grade','GradeController@grade')->name('grade');
    Route::get('/grade_add','GradeController@grade_add')->name('grade_add');
    Route::post('/grade_add','GradeController@grade_doadd')->name('grade_doadd');
    Route::get('/grade_edit/{id}','GradeController@grade_edit')->name('grade_edit');
    Route::post('/grade_doedit/{id}','GradeController@grade_doedit')->name('grade_doedit');
    Route::get('/grade_typr','GradeController@grade_typr')->name('grade_typr');
    Route::get('/grade_del','GradeController@grade_del')->name('grade_del');
    
    // 后台 管理
    Route::get('/admin','AdminController@index')->name('admin_index');
    Route::get('/home','AdminController@home')->name('admin_home');
});

// 登陆
Route::get('/admin_login','loginController@login')->name('login');
Route::get('/admin_captcha','loginController@captcha')->name('captcha');
Route::post('/admin_login','loginController@dologin')->name('dologin');



// 首页
Route::get('/','IndexController@index')->name('index');

// 前台登陆
Route::get('/register','UserController@register')->name('register');
Route::post('/register','UserController@doregister')->name('doregister');
Route::get('/sns','UserController@sns')->name('sns');
Route::get('/login','UserController@login')->name('user_login');
Route::post('/login','UserController@dologin')->name('user_dologin');

// 商品
Route::get('/goods_content/{id}/{skuid}','ContentController@goods_content')->name('goods_content');
// 购物车
Route::get('/incart','ContentController@incart')->name('incart');
Route::get('/cart','ContentController@cart')->name('cart');



