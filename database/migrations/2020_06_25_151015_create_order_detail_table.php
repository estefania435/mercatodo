<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->bigIncrements('OrderDetailId');
            $table->unsignedBigInteger('OrderId');
            $table->unsignedBigInteger('ProductId');
            $table->bigInteger('ProductQuantity');
            $table->bigInteger('TotalProducts');
            $table->timestamps();
            $table->foreign('OrderId')->references('OrderId')->on('orders');
            $table->foreign('ProductId')->references('ProductId')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
}
