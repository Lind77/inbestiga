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
        Schema::table('recovery_dates', function (Blueprint $table) {
            $table->unsignedBigInteger('recoverable_id');
            $table->string('recoverable_type');
            $table->dropForeign(['attendance_permit_id']);
            $table->dropColumn('attendance_permit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recovery_dates', function (Blueprint $table) {
            $table->dropColumn('recoverable_id');
            $table->dropColumn('recoverable_type');
            $table->unsignedBigInteger('attendance_permit_id')->nullable();
            $table->foreign('attendance_permit_id')->references('id')->on('attendance_permits')->onDelete('cascade');
        });
    }
};
