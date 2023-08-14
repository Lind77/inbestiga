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
        Schema::table('attendance_permits', function (Blueprint $table) {
            $table->dropColumn('recovery_time_admission');
            $table->dropColumn('recovery_time_departure');
            $table->integer('time_amount')->nullable();
            $table->integer('left_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_permits', function (Blueprint $table) {
            //
        });
    }
};
