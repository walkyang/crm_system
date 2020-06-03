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

Route::get('/',function(){
    return view('login');
});
Route::get('/400',function(){
    return view('400');
});
Route::post('/login','AdminController@admin_login');
Route::any('/admin/import','AdminController@admin_import');
Route::get('/admin/export','AdminController@admin_export');
Route::any('/file/uploads', 'UploadController@upload_file');

Route::group(['middleware' => ['crm.login']], function () {
    
    Route::get('/home','HomeController@index');
    Route::any('/admin/list','AdminController@admin_list');
    Route::any('/admin/list/{page?}','AdminController@admin_list')->where('page', '[1-9]+');
    Route::get('/admin/info/{id?}','AdminController@admin_info')->where('id', '[0-9]+');
    Route::post('/admin/add','AdminController@admin_add');
    Route::get('/admin/delete/{ids}','AdminController@admin_delete');
    Route::post('/admin/power/add','AdminPowerController@admin_power_add');
    Route::get('/admin/power/{ids?}','AdminPowerController@admin_power_info');
    Route::get('/admin/view-setting/info/{id}','AdminViewSettingController@admin_view_info');
    Route::post('/admin/view-setting/add','AdminViewSettingController@admin_view_add');

    Route::get('/department/list','HomeController@index');

    Route::get('/user/list','HomeController@index');
    Route::get('/product/list','HomeController@index');
    Route::get('/order/list','HomeController@index');

});