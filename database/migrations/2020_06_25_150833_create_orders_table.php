<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('OrderId');
            $table->unsignedBigInteger('UserId');
            $table->dateTime('OrderDate');
            $table->char('AddressShipping');
            $table->bigInteger('Phone');
            $table->enum('StatusOrder', ['pending', 'processing'])->default('pending');
            $table->timestamps();
            $table->foreign('UserId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
