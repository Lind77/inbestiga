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
        Schema::create('aproduct_aindicator', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_product_id')->nullable();
            $table->foreign('academic_product_id')->references('id')->on('academic_products')->onDelete('cascade');
            $table->unsignedBigInteger('acceptance_indicator_id')->nullable();
            $table->foreign('acceptance_indicator_id')->references('id')->on('acceptance_indicators')->onDelete('cascade');
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
        Schema::dropIfExists('aproduct_aindicator');
    }
};
