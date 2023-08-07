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
            $table->time('miss_time_admission')->nullable();
            $table->time('miss_time_departure')->nullable();
            $table->time('recovery_time_admission')->nullable();
            $table->time('recovery_time_departure')->nullable();
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
            $table->dropColumn('miss_time');
            $table->dropColumn('revocery_time');
        });
    }
};
