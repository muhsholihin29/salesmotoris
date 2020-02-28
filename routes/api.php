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

Route::middleware('auth:api')->post('/user', function (Request $request) {
	return $request->user();
});
Route::prefix('v2')->group(function () {
	Route::prefix('auth')->group(function () {
		Route::post('/login', 'api\ApiAuthController@login');
		Route::post('/register', 'api\ApiAuthController@register');
	});
});

Route::
middleware('auth:api')->
prefix('v2')->group(function () {
	Route::prefix('store')->group(function () {
		Route::get('/', 'api\ApiStoreController@index');
		Route::get('{id}', 'api\ApiStoreController@getById');
		Route::post('/', 'api\ApiStoreController@create');
		Route::get('{id}/edit', 'api\ApiStoreController@edit');
		Route::put('{id}', 'api\ApiStoreController@update');
		Route::delete('{id}', 'api\ApiStoreController@delete');
	});
	Route::prefix('product')->group(function () {
		Route::get('/', 'api\ApiProductController@index');
	});
	Route::prefix('visitation')->group(function () {
		Route::get('/', 'api\ApiVisitationController@index');
	});
	Route::prefix('transaction')->group(function () {
		Route::get('/', 'api\ApiTransactionController@index');
		Route::get('{id}', 'api\ApiTransactionController@getDetail');
		Route::put('/', 'api\ApiTransactionController@update');
		Route::get('{id}/edit', 'api\ApiTransactionController@edit');
		// Route::put('{id}', 'api\ApiTransactionController@update');
		Route::delete('{id}', 'api\ApiTransactionController@delete');
	});
	Route::prefix('stock')->group(function () {
		Route::get('/', 'api\ApiStockController@index');
		Route::post('/', 'api\ApiStockController@update');
	});
	Route::prefix('report')->group(function () {
		Route::get('/', 'api\ApiReportController@index');
		// Route::post('/', 'api\ApiReportController@update');
	});
});

// Route::group(['prefix' => '/v2z'], function(){ //bagian crud
// 	Route::post('approve', [
// 		'uses' => 'StoreController@approve',
// 		'middleware' => 'auth'
// 	]);
// 	Route::post('add-store', [
// 		'uses' => 'StoreController@addStore',
// 		'middleware' => 'api'
// 	]);
// 	Route::get('zzz', [
// 		'uses' => 'StoreController@zzz'
// 	]);
// });

// Route::group(['middleware' => 'api'], function () {
	// Route::post('/api/crud/add-store', 'StoreController@addStore');
// });
// Route::get('/login', 'MainController@loginPage');