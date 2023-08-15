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
        Schema::create('justifications', function (Blueprint $table) {
            $table->id();
            $table->date('miss_date')->nullable();
            $table->time('admission_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->text('reason')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('justifications');
    }
};
