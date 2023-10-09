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
        Schema::table('areas', function (Blueprint $table) {
            $table->tinyInteger('hierarchy')->nullable();
            $table->unsignedBigInteger('father_id')->nullable();
            $table->foreign('father_id')->references('id')->on('areas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('hierarchy');
            $table->dropForeign(['father_id']);
            $table->dropColumn('father_id');
        });
    }
};
