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

Route::middleware('auth')->group(function () {

	Route::get('/', 'TargetController@index');	

	Route::get('/store', 'StoreController@index');
	Route::get('/store/{id}/edit', 'StoreController@getEdit');
	Route::post('/store', 'StoreController@update');
	Route::post('/store/del', 'StoreController@delete');
	Route::post('/store/approve', 'StoreController@approve');

	Route::get('/product', 'ProductController@index');
	Route::post('/product', 'ProductController@addUpdate');
	Route::get('/product/{id}/edit', 'ProductController@getEdit');
	Route::put('/product/{id}', 'ProductController@update');
	Route::post('/product/del', 'ProductController@delete');

	Route::get('/visitation', 'VisitationController@index');
	Route::post('/visitation', 'VisitationController@addUpdate');
	Route::get('/visitation/{id}/edit', 'VisitationController@getEdit');
	Route::get('/visitation/{id}', 'VisitationController@getId');
	Route::post('/visitation/del', 'VisitationController@delete');

	Route::get('/stock', 'StockController@index');
	Route::get('/stock/{id}', 'StockController@getId');
	Route::post('/stock', 'StockController@addUpdate');
	Route::get('/stock/{id}/edit', 'StockController@getEdit');
	Route::put('/stock/{id}', 'StockController@update');
	Route::post('/stock/del', 'StockController@delete');

	Route::group(['prefix' => 'target'], function(){
		
		Route::post('/', 'TargetController@update');
		Route::get('/edit', 'TargetController@getEdit');
		Route::put('/{id}', 'TargetController@update');

		Route::post('product-focus', 'TargetController@prFocusAddUpdate');
		Route::get('product-focus/{id}/edit', 'TargetController@prFocusGetEdit');
		Route::put('product-focus/{id}', 'TargetController@update');
		Route::post('product-focus/del', 'TargetController@prFocusDel');
	});

	Route::group(['prefix' => 'report'], function(){
		Route::get('/sales', 'ReportController@index');

		Route::get('/store', 'ReportController@store');
		Route::get('/', 'ReportController@daily');

		Route::post('product-focus', 'TargetController@prFocusAddUpdate');
		Route::get('product-focus/{id}/edit', 'TargetController@prFocusGetEdit');
		Route::put('product-focus/{id}', 'TargetController@update');
		Route::post('product-focus/del', 'TargetController@prFocusDel');


	});
	Route::group(['prefix' => 'sales'], function(){
		Route::get('register', 'SalesController@index');
		Route::post('register', 'SalesController@register');
		Route::post('register/cek-username', 'SalesController@registerCekUsername');
		Route::post('register/cek-email', 'SalesController@registerCekEmail');
	});
});
Route::get('/login', 'MainController@loginPage');
Route::get('/report/print', 'ReportController@print');

Auth::routes(); 

Route::get('/home', 'HomeController@index')->name('home');
