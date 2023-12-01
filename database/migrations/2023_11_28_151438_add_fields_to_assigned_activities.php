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
            $table->integer('points')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('academic_level')->nullable();
            $table->dropColumn('title');
            $table->dropColumn('type');
            $table->dropColumn('progress');
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
            $table->dropColumn('points');
            $table->dropColumn('name');
            $table->dropColumn('academic_level');
            $table->string('title')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->double('progress')->nullable();
        });
    }
};
