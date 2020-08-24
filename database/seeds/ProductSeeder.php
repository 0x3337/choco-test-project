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
    $this->createMacs($faker);
    $this->createTvs($faker);
    $this->createHeadphones($faker);
  }


  private function createProduct($faker, $name, $categoryId, $minPrice, $maxPrice) {
    $filename = Helper::slugify($name) . '.jpg';

    $product = Product::create([
      'name' => $name,
      'price' => $faker->numberBetween($minPrice, $maxPrice),

      'filename' => $filename,
    ]);

    $product->save();
    $product->categories()->attach($categoryId);
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
      $this->createProduct($faker, $iphone, 1, 399, 999);
    }
  }

  private function createMacs($faker) {
    $macs = [
      'MacBook Pro 2019',
      'MacBook Air 2020',
    ];

    foreach ($macs as $mac) {
      $this->createProduct($faker, $mac, 2, 999, 1999);
    }
  }

  private function createTvs($faker) {
    $tvs = [
      'Samsung QE65Q800TAUXCE QLED 8K',
    ];

    foreach ($tvs as $tv) {
      $this->createProduct($faker, $tv, 3, 1999, 3999);
    }
  }

  private function createHeadphones($faker) {
    $headphones = [
      'AirPods Pro',
      'Powerbeats Pro',
      'Monster Beats',
    ];

    foreach ($headphones as $headphone) {
      $this->createProduct($faker, $headphone, 4, 50, 300);
    }
  }
}
