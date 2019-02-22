<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_product', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->default('');
            $table->string('slug')->default('');
            $table->string('status')->default('active');
            $table->string('description')->default('');
            $table->boolean('show_frontend')->default(0);
            $table->integer('level')->default(0);
            $table->integer('left')->default(0);
            $table->integer('right')->default(0);
            $table->integer('parent')->default(0);
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
        Schema::dropIfExists('categories_product');
    }
}
