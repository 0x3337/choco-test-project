<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Category;

Route::post('/create', function (Request $request) {
  try {
    $category = Category::create([
      'name' => $request->input('name'),
      'slug' => $request->input('slug'),
    ]);

    $category->save();

    return Response::json([
      'success' => true,
    ]);
  } catch (Throwable $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});

Route::post('/update', function (Request $request) {
  try {
    return Response::json([
      'success' => true,
    ]);
  } catch (Throwable $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});

Route::post('get_all', function (Request $request) {
  try {
    $categories = Category::select('name', 'slug')->get();
    return Response::json([
      'success' => true,
      'categories' => $categories,
    ]);
  } catch (Throwable $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});