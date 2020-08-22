<?php

use Illuminate\Support\Facades\Route;

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
	return view('pages.home');
});

Route::get('/shop/p/{product_id?}', function ($product_id = null) {
  return view('pages.shop.product');
});

Route::get('/shop/{category?}', function ($category = null) {
  return view('pages.shop.shop');
});
