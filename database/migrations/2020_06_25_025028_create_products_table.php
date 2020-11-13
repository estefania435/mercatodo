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
            $table->string('name', 20)->unique();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('category_id');
            $table->bigInteger('quantity')->unsigned()->default(0);
            $table->decimal('price')->default(0);
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->text('data_of_interest')->nullable();

            $table->string('status');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');
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
