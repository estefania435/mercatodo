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
            $table->bigIncrements('ProductId');
            $table->unsignedBigInteger('CategoryId');
            $table->string('ProductName');
            $table->bigInteger('PriceProduct');
            $table->longText('DescriptionProduct');
            $table->string('ImageProduct');
            $table->bigInteger('UnitsAvailable');
            $table->timestamps();
            $table->foreign('CategoryId')->references('CategoryId')->on('categories');
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
