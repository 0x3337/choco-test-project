<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

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

Route::post('/get_all', function (Request $request) {
  try {
    $categorySlugs = $request->input('categories');

    $productList = [];
    $products = [];

    if (is_null($categorySlugs)) {
      $productList = Product::get();
    } else {
      if (!is_array($categorySlugs)) {
        $categorySlugs = [$categorySlugs];
      }

      $productList = Product::whereHas('categories', function (Builder $query) use ($categorySlugs) {
        $query->whereIn('slug', $categorySlugs);
      })->get();
    }

    foreach ($productList as $p) {
      array_push($products, [
        'name' => $p->name,
        'price' => $p->price,
        'imagePath' => Storage::url($p->filename),
      ]);
    }

    return Response::json([
      'success' => true,
      'products' => $products,
    ]);
  } catch (Throwable $error) {
    return Response::json([
      'success' => false,
    ]);
  }
});