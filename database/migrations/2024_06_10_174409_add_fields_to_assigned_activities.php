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
        Schema::table('assigned_activities', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('academic_date');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigned_activities', function (Blueprint $table) {
            $table->dateTime('date')->nullable();
            $table->dateTime('academic_date')->nullable();
        });
    }
};
