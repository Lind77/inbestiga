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
        Schema::create('career_degree', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_id')->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
            $table->unsignedBigInteger('degree_id')->nullable();
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');
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
        Schema::dropIfExists('career_degree');
    }
};
