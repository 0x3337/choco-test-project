<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Product;

Route::post('/create', function (Request $request) {
  $categoryIds = $request->input('categoryIds');

  try {
    $product = Product::create([
      'name' => $request->input('name'),
      'price' => $request->input('price'),

      'package_width' => $request->input('width'),
      'package_height' => $request->input('height'),
      'package_depth' => $request->input('depth'),
      'package_weight' => $request->input('weight'),
    ]);

    $product->save();
    $product->categories()->attach($categoryIds);

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