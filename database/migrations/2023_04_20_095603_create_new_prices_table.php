<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('new_product_id');
            $table->foreign('new_product_id')->references('id')->on('new_products')->onDelete('cascade');
            $table->tinyInteger('level');
            $table->double('price');
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
        Schema::dropIfExists('new_prices');
    }
};
