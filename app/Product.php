<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'price',

    'package_width',
    'package_height',
    'package_depth',
    'package_weight',
  ];

  /**
   * The categories that belong to the product.
   */
  public function categories()
  {
    return $this->belongsToMany('App\Category', 'category_by_products', 'product_id', 'category_id');
  }
}
