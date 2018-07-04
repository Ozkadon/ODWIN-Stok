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

Route::match(array('GET','POST'),'/backend/login','Backend\LoginController@index');

/* SUPER ADMIN */
Route::group(array('prefix' => 'backend','middleware'=> ['token_super_admin']), function()
{
	Route::resource('/modules', 'Backend\ModuleController');
	Route::get('/datatable/module','Backend\ModuleController@datatable');
});

/* ACCESS CONTROL EDIT */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin', 'token_edit']), function()
{
	Route::get('/users-level/{id}/edit','Backend\UserLevelController@edit');
	Route::match(array('PUT','PATCH'),'/users-level/{id}','Backend\UserLevelController@update');

	Route::get('/users-user/{id}/edit','Backend\UserController@edit');
    Route::match(array('PUT','PATCH'),'/users-user/{id}','Backend\UserController@update');

	Route::get('/supplier/{id}/edit','Backend\SupplierController@edit');
	Route::match(array('PUT','PATCH'),'/supplier/{id}','Backend\SupplierController@update');
    
	Route::get('/barang/{id}/edit','Backend\BarangController@edit');
	Route::match(array('PUT','PATCH'),'/barang/{id}','Backend\BarangController@update');

	Route::get('/purchase-order/{id}/edit','Backend\PurchaseController@edit');
	Route::match(array('PUT','PATCH'),'/purchase-order/{id}','Backend\PurchaseController@update');

});

/* ACCESS CONTROL ALL */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin', 'token_all']), function()
{
	Route::get('/users-level/create','Backend\UserLevelController@create');
	Route::post('/users-level','Backend\UserLevelController@store');
	Route::delete('/users-level/{id}','Backend\UserLevelController@destroy');
	
	Route::get('/users-user/create','Backend\UserController@create');
	Route::post('/users-user','Backend\UserController@store');
    Route::delete('/users-user/{id}','Backend\UserController@destroy');
    Route::post('/users-user/delete','Backend\UserController@deleteAll');

	Route::get('/media-library/upload','Backend\MediaLibraryController@upload');
	Route::post('/media-library/upload','Backend\MediaLibraryController@upload');	
    Route::delete('/media-library/{id}','Backend\MediaLibraryController@destroy');
    Route::post('/media-library','Backend\MediaLibraryController@deleteAll');

	Route::get('/supplier/create','Backend\SupplierController@create');
	Route::post('/supplier','Backend\SupplierController@store');
	Route::delete('/supplier/{id}','Backend\SupplierController@destroy');
    
	Route::get('/barang/create','Backend\BarangController@create');
	Route::post('/barang','Backend\BarangController@store');
	Route::delete('/barang/{id}','Backend\BarangController@destroy');

	Route::get('/purchase-order/create','Backend\PurchaseController@create');
	Route::post('/purchase-order','Backend\PurchaseController@store');
	Route::delete('/purchase-order/{id}','Backend\PurchaseController@destroy');
    Route::post('/purchase-order/terima/{id}','Backend\PurchaseController@received');

	Route::get('/penjualan/create','Backend\PenjualanController@create');
	Route::post('/penjualan','Backend\PenjualanController@store');
	Route::delete('/penjualan/{id}','Backend\PenjualanController@destroy');

});

/* ACCESS CONTROL VIEW */
Route::group(array('prefix' => 'backend','middleware'=> ['token_admin']), function()
{
	Route::get('',function (){return Redirect::to('backend/dashboard');});
	Route::get('/logout','Backend\LoginController@logout');
	
	Route::get('/dashboard','Backend\DashboardController@dashboard');

	Route::get('/users-level/datatable','Backend\UserLevelController@datatable');	
	Route::get('/users-level','Backend\UserLevelController@index');
	Route::get('/users-level/{id}','Backend\UserLevelController@show');
	
	Route::get('/users-user/datatable','Backend\UserController@datatable');
	Route::get('/users-user','Backend\UserController@index');
	Route::get('/users-user/{id}','Backend\UserController@show');
    Route::get('/user/export/{type}','ExcelController@export_user');

	Route::get('/media-library/datatable/','Backend\MediaLibraryController@datatable');
	Route::get('/media-library','Backend\MediaLibraryController@index');
	Route::get('/media-library/popup-media/{from}/{id_count}','Backend\MediaLibraryController@popup_media');
    Route::get('/media-library/popup-media-gallery/','Backend\MediaLibraryController@popup_media_gallery');
    Route::get('/media-library/popup-media-editor/{id_count}','Backend\MediaLibraryController@popup_media_editor');
	
	Route::get('/access-control','Backend\AccessControlController@index');
	Route::post('/access-control','Backend\AccessControlController@update');

	Route::get('/setting','Backend\SettingController@index');
	Route::post('/setting','Backend\SettingController@update');
    
	Route::get('/supplier/datatable','Backend\SupplierController@datatable');
	Route::get('/supplier','Backend\SupplierController@index');
	Route::get('/supplier/{id}','Backend\SupplierController@show');
    
	Route::get('/barang/datatable','Backend\BarangController@datatable');
	Route::get('/barang','Backend\BarangController@index');
    Route::get('/barang/{id}','Backend\BarangController@show');
    Route::get('/barang/harga/{id}','Backend\BarangController@histori');

	Route::get('/purchase-order/datatable','Backend\PurchaseController@datatable');
	Route::get('/purchase-order','Backend\PurchaseController@index');
	Route::get('/purchase-order/{id}','Backend\PurchaseController@show');
    Route::get('/purchase-order/barang/popup-media/{id_count}','Backend\PurchaseController@popup_media_barang');
    Route::get('/purchase-order/supplier/popup-media','Backend\PurchaseController@popup_media_supplier');

    Route::get('/browse-barang/datatable','Backend\BarangController@datatable_barang');
    Route::get('/browse-supplier/datatable','Backend\SupplierController@datatable_supplier');

	Route::get('/inden/datatable','Backend\IndenController@datatable');
	Route::get('/inden','Backend\IndenController@index');

	Route::get('/penjualan/datatable','Backend\PenjualanController@datatable');
	Route::get('/penjualan','Backend\PenjualanController@index');
	Route::get('/penjualan/{id}','Backend\PenjualanController@show');
    Route::get('/penjualan/barang/popup-media/{id_count}','Backend\PenjualanController@popup_media_barang');

    Route::get('/report-purchase','Backend\LaporanController@index_purchase');
    Route::get('/report-penjualan','Backend\LaporanController@index_penjualan');
    Route::get('/report-stok','Backend\LaporanController@index_stok');

	Route::get('/koreksi-stok','Backend\KoreksiController@index');
    Route::post('/koreksi-stok','Backend\KoreksiController@update');
    Route::get('/koreksi-stok/barang/popup-media/','Backend\KoreksiController@popup_media_barang');
});