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

use App\Http\Middleware\HelloMiddleware;
use App\Http\Controllers\Sample\SampleController;

Route::get('/hello', 'HelloController@index');

// Route::get('/hello/{id}', 'HelloController@index');
// Route::get('/hello/other', 'HelloController@other');

// Route::get('/hello/other', 'HelloController@other');
// Route::get('/hello', 'HelloController@index')->name('hello');

// Route::get('/hello', 'HelloController@index');
// Route::post('/hello', 'HelloController@index');

// Route::get('/hello', 'HelloController@index')->name('hello');
// Route::get('/hello/{msg}', 'HelloController@other');
// Route::get('/hello/other', 'HelloController@other');
// Route::get('/sample', 'Sample\SampleController@index')->name('sample');

// Route::get('/hello/{person}', 'HelloController@index');

// Route::namespace('Sample')->group(function () {
//     Route::get('/sample', 'SampleController@index');
//     Route::get('/sample/other', 'SampleController@other');
// });

// Route::middleware([HelloMiddleware::class])->group(function () {
//     Route::get('/hello', 'HelloController@index');
//     Route::get('/hello/other', 'HelloController@other');
// });

// Route::get('/hello', 'HelloController@index');
// Route::get('/hello/{id}', 'HelloController@index')->where('id','[0-9]+');