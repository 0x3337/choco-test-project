<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Http\Resources\Category as CategoryResource;

class CategoryController extends Controller
{
  public function create(Request $request)
  {
    try {
      $category = Category::create([
        'name' => $request->input('name'),
        'slug' => $request->input('slug'),
      ]);

      $category->save();

      return response()->json([
        'success' => true,
        'category' => new CategoryResource($category),
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
      $category = Category::find($request->input('id'));

      $category->name = $request->input('name', $category->name);
      $category->slug = $request->input('slug', $category->slug);

      $category->save();

      return response()->json([
        'success' => true,
        'category' => new CategoryResource($category),
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
      $category = Category::find($request->input('id'));
      $category->delete();

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
      $categories = Category::all();

      return response()->json([
        'success' => true,
        'categories' => CategoryResource::collection($categories),
      ]);
    } catch (Exception $error) {
      return response()->json([
        'success' => false,
      ]);
    }
  }
}
