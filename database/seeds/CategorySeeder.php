<?php

use Illuminate\Database\Seeder;

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
        'slug' => $this->slugify($c),
      ]);

      $category->save();
    }
  }


  private function slugify($text) {
    $text = preg_replace('/&/', 'and', $text);
    $text = preg_replace('/[^\pL\d]+/u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('/[^-\w]+/', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('/-+/', '-', $text);
    $text = strtolower($text);

    if (empty($text)) {
      return 'n-a';
    }

    return $text;
  }
}
