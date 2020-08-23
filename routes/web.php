<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\User;
use App\Category;

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

Route::get('/login', function () {
  if (Auth::check()) {
    return redirect('/');
  }

  return view('pages.login');
});

Route::get('/logout', function () {
  Auth::logout();
  return redirect('/');
});

Route::get('/shop/p/{product_id?}', function ($product_id = null) {
  return view('pages.shop.product');
});

Route::get('/shop/{categorySlug?}', function ($categorySlug = null) {
  $category = Category::where('slug', $categorySlug)->first();
  return view('pages.shop.shop', ['category' => $category]);
});
