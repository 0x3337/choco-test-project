<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'product'], function() {
  Route::group(['middleware' => ['role:admin']], function() {
    Route::post('create', 'ProductController@create');
    Route::post('update', 'ProductController@update');
    Route::post('delete', 'ProductController@delete');
  });

  Route::post('get_all', 'ProductController@getAll');
});

Route::group(['prefix' => 'category'], function() {
  Route::group(['middleware' => ['role:admin']], function() {
    Route::post('create', 'CategoryController@create');
    Route::post('update', 'CategoryController@update');
    Route::post('delete', 'CategoryController@delete');
  });

  Route::post('get_all', 'CategoryController@getAll');
});