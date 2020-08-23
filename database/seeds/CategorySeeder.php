<?php

use Illuminate\Database\Seeder;

use App\Helpers\Helper;
use App\Category;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $categories = [
      'Phones',
      'Computers',
      'TV',
      'Headphones',
      'Camera & photo',
    ];

    foreach ($categories as $c) {
      $category = Category::create([
        'name' => $c,
        'slug' => Helper::slugify($c),
      ]);

      $category->save();
    }
  }
}
