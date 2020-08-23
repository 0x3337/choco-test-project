<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id();
      $table->string('name', 180);
      $table->decimal('price', 10, 2)->nullable()->default(0.00);

      $table->double('package_width')->nullable();
      $table->double('package_height')->nullable();
      $table->double('package_depth')->nullable();
      $table->double('package_weight')->nullable();

      $table->string('filename')->nullable();
      
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('products');
  }
}
