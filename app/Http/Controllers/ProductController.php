<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Product;
use App\Http\Resources\Product as ProductResource;

class ProductController extends Controller
{
  public function create(Request $request)
  {
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

      return response()->json([
        'success' => true,
        'product' => new ProductResource($product),
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
      ]);
    }
  }

  public function update(Request $request)
  {
    try {
      $product = Product::find($request->input('id'));

      $product->name = $request->input('name', $product->name);
      $product->price = $request->input('price', $product->price);

      $product->package_width = $request->input('package_width', $product->package_width);
      $product->package_height = $request->input('package_height', $product->package_height);
      $product->package_depth = $request->input('package_depth', $product->package_depth);
      $product->package_weight = $request->input('package_weight', $product->package_weight);

      $product->save();

      return response()->json([
        'success' => true,
        'product' => new ProductResource($product),
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
      ]);
    }
  }

  public function delete(Request $request)
  {
    try {
      $product = Product::find($request->input('id'));
      $product->delete();

      return response()->json([
        'success' => true,
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
      ]);
    }
  }

  public function getAll(Request $request)
  {
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

      return response()->json([
        'success' => true,
        'products' => ProductResource::collection($products),
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
      ]);
    }
  }
}
