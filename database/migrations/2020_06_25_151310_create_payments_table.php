<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('PayId');
            $table->unsignedBigInteger('OrderDetailId');
            $table->bigInteger('TotalPayment');
            $table->enum('StatusPay', ['pending', 'paid out'])->default('pending');
            $table->timestamps();
            $table->foreign('OrderDetailId')->references('OrderDetailId')->on('order_detail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
