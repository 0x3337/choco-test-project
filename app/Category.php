<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'slug',
  ];

  /**
   * The products that belong to the category.
   */
  public function products()
  {
    return $this->belongsToMany('App\Product', 'category_by_products', 'category_id', 'product_id');
  }
}
