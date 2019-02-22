<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name')->unique()->default('');
            $table->string('slug')->default('');
            $table->string('status')->default('active');
            $table->string('description')->default('');
            $table->text('content');
            $table->string('image');
            $table->integer('price')->default(0);
            $table->integer('price_old')->default(0);
            $table->unsignedInteger('category_product_id')->default(0);
            $table->foreign('category_product_id')->references('id')->on('categories_product')->onDelete('cascade');
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
