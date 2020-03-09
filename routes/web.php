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

// Route::get('/', function () {
// 	return view('tes');
// });
Route::get('/', 'MainController@index');
Route::middleware('auth')->group(function () {
	Route::get('/store', 'StoreController@index');
	Route::get('/store/{id}/edit', 'StoreController@edit');
	Route::put('/store/{id}', 'StoreController@update');
	Route::delete('/store/{id}', 'StoreController@delete');

	Route::get('/product', 'ProductController@index');
	Route::post('/product', 'ProductController@addUpdate');
	Route::get('/product/{id}/edit', 'ProductController@getEdit');
	Route::put('/product/{id}', 'ProductController@update');
	Route::delete('/product/', 'ProductController@delete');

	Route::get('/visitation', 'VisitationController@index');
	Route::post('/visitation', 'VisitationController@addUpdate');
	Route::get('/visitation/{id}/edit', 'VisitationController@getEdit');
	Route::put('/visitation/{id}', 'VisitationController@update');
	Route::delete('/visitation/', 'VisitationController@delete');

	Route::group(['prefix' => 'target'], function(){
		Route::get('/', 'TargetController@index');
		Route::post('/', 'TargetController@update');
		Route::get('/edit', 'TargetController@getEdit');
		Route::put('/{id}', 'TargetController@update');
		Route::delete('/', 'TargetController@delete');

		Route::post('product-focus', 'TargetController@prFocusAddUpdate');
		Route::get('product-focus/{id}/edit', 'TargetController@prFocusGetEdit');
		Route::put('product-focus/{id}', 'TargetController@update');
		Route::post('product-focus/del', 'TargetController@prFocusDel');
	});

	Route::group(['prefix' => 'report'], function(){
		Route::get('/', 'ReportController@index');

		Route::get('/store', 'ReportController@store');
		Route::get('/product', 'ReportController@product');

		Route::post('product-focus', 'TargetController@prFocusAddUpdate');
		Route::get('product-focus/{id}/edit', 'TargetController@prFocusGetEdit');
		Route::put('product-focus/{id}', 'TargetController@update');
		Route::post('product-focus/del', 'TargetController@prFocusDel');
	});
});
// Route::group(['middleware' => 'api'], function () {
	// Route::post('/api/crud/add-store', 'StoreController@addStore');
// });
// Route::get('/login', 'MainController@loginPage');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
