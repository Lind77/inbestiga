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
        Schema::table('justifications', function (Blueprint $table) {
            $table->time('miss_time_admission')->nullable();
            $table->time('miss_time_departure')->nullable();
            $table->integer('left_time')->nullable();
            $table->integer('time_amount')->nullable();
            $table->dropColumn('admission_time');
            $table->dropColumn('departure_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('justifications', function (Blueprint $table) {
            $table->dropColumn('miss_time_admission');
            $table->dropColumn('miss_time_departure');
            $table->dropColumn('left_time');
            $table->dropColumn('time_amount');
            $table->time('admission_time')->nullable();
            $table->time('departure_time')->nullable();
        });
    }
};
