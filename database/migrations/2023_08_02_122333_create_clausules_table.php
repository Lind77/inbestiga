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
        Schema::create('clausules', function (Blueprint $table) {
            $table->id();
            $table->text('title', 800)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('work_contract_id')->nullable();
            $table->foreign('work_contract_id')->references('id')->on('work_contracts')->onDelete('cascade');
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
        Schema::dropIfExists('clausules');
    }
};
