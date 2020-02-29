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
// Route::get('/store', '');
Route::get('/store', [
	'uses' => 'StoreController@index',
	'middleware' => 'auth'
]);

// Route::group(['middleware' => 'api'], function () {
	// Route::post('/api/crud/add-store', 'StoreController@addStore');
// });
// Route::get('/login', 'MainController@loginPage');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
