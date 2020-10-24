<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table)
        {
            $table->id();
            $table->integer('quantity')->default(0);
            $table->unsignedBigInteger('products_id');
            $table->unsignedDecimal('unit_price');
            $table->unsignedBigInteger('order_id');
            $table->foreign('products_id')->references('id')->on('products');
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('details');
    }
}
