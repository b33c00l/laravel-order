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
            $table->unsignedInteger('platform_id');
            $table->unsignedInteger('publisher_id')->nullable();
            $table->bigInteger('ean');
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('release_date')->nullable();
            $table->string('video')->nullable();
            $table->integer('pegi')->nullable();
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
