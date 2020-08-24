<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;

use App\Product;
use App\Http\Resources\Product as ProductResource;

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
      'product' => new ProductResource($product),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('/update', function (Request $request) {
  try {
    $product = Product::find($request->input('id'));

    $product->name = $request->input('name', $product->name);
    $product->price = $request->input('price', $product->price);

    $product->package_width = $request->input('package_width', $product->package_width);
    $product->package_height = $request->input('package_height', $product->package_height);
    $product->package_depth = $request->input('package_depth', $product->package_depth);
    $product->package_weight = $request->input('package_weight', $product->package_weight);

    $product->save();

    return Response::json([
      'success' => true,
      'product' => new ProductResource($product),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('/delete', function (Request $request) {
  try {
    $product = Product::find($request->input('id'));
    $product->delete();

    return Response::json([
      'success' => true,
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
})->middleware('auth');

Route::post('/get_all', function (Request $request) {
  try {
    $categorySlugs = $request->input('categories');

    $products = [];

    if (is_null($categorySlugs)) {
      $products = Product::get();
    } else {
      if (!is_array($categorySlugs)) {
        $categorySlugs = [$categorySlugs];
      }

      $products = Product::whereHas('categories', function (Builder $query) use ($categorySlugs) {
        $query->whereIn('slug', $categorySlugs);
      })->get();
    }

    return Response::json([
      'success' => true,
      'products' => ProductResource::collection($products),
    ]);
  } catch (Exception $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});