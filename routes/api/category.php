<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Category;
use App\Http\Resources\Category as CategoryResource;

Route::post('/create', function (Request $request) {
  try {
    $category = Category::create([
      'name' => $request->input('name'),
      'slug' => $request->input('slug'),
    ]);

    $category->save();

    return Response::json([
      'success' => true,
      'category' => new CategoryResource($category),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('/update', function (Request $request) {
  try {
    $category = Category::find($request->input('id'));

    $category->name = $request->input('name', $category->name);
    $category->slug = $request->input('slug', $category->slug);

    $category->save();

    return Response::json([
      'success' => true,
      'category' => new CategoryResource($category),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('/delete', function (Request $request) {
  try {
    $category = Category::find($request->input('id'));
    $category->delete();

    return Response::json([
      'success' => true,
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('get_all', function (Request $request) {
  try {
    $categories = Category::all();

    return Response::json([
      'success' => true,
      'categories' => CategoryResource::collection($categories),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});