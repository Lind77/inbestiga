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
        Schema::create('attendance_permits', function (Blueprint $table) {
            $table->id();
            $table->date('miss_date')->nullable();
            $table->time('miss_time')->nullable();
            $table->text('reason')->nullable();
            $table->date('recovery_date')->nullable();
            $table->time('revocery_time')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('attendance_id')->nullable();
            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
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
        Schema::dropIfExists('attendance_permits');
    }
};
