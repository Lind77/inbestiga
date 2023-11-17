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
        Schema::create('academic_level_academic_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_product_id')->nullable();
            $table->foreign('academic_product_id')->references('id')->on('academic_products')->onDelete('cascade');
            $table->unsignedBigInteger('academic_level_id')->nullable();
            $table->foreign('academic_level_id')->references('id')->on('academic_levels')->onDelete('cascade');
            $table->tinyInteger('points')->nullable();
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
        Schema::dropIfExists('academic_level_academic_product');
    }
};
