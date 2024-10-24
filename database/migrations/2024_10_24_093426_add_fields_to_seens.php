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
        Schema::table('seens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id'); 
            $table->unsignedBigInteger('seenable_id');
            $table->string('seenable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seens', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->dropColumn('seenable_id');
            $table->dropColumn('seenable_type');
        });
    }
};
