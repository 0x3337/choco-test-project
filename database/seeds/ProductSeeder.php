<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

use App\Helpers\Helper;
use App\Product;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Factory::create();
    $this->createIphones($faker);
  }


  private function createIphones($faker) {
    $iphones = [
      'iPhone 6S',
      'iPhone 7',
      'iPhone SE',
      'iPhone XS',
      'iPhone 11',
    ];

    foreach ($iphones as $iphone) {
      $filename = Helper::slugify($iphone) . '.jpg';

      $product = Product::create([
        'name' => $iphone,
        'price' => $faker->numberBetween(399, 999),

        'filename' => $filename,
      ]);

      $product->save();
      $product->categories()->attach(1);
    }
  }
}
