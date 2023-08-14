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
        Schema::create('recovery_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_permit_id')->nullable();
            $table->foreign('attendance_permit_id')->references('id')->on('attendance_permits')->onDelete('cascade');
            $table->date('recovery_date')->nullable();
            $table->time('admission_time')->nullable();
            $table->time('departure_time')->nullable();
            $table->integer('amount_recovered')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('recovery_dates');
    }
};
