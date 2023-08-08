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
        Schema::create('proof_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_proof_id')->nullable();
            $table->foreign('payment_proof_id')->references('id')->on('payment_proofs')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->text('product_name',200)->nullable();
            $table->double('unit_price')->nullable();
            $table->double('partial_price')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('proof_details');
    }
};
