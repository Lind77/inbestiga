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
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['emisor_id']);
            $table->dropColumn('emisor_id'); 
            $table->unsignedBigInteger('notificable_id');
            $table->string('notificable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('emisor_id')->nullable();
            $table->foreign('emisor_id')->references('id')->on('users')->nullOnDelete();
            $table->dropColumn('notificable_id');
            $table->dropColumn('notificable_type');
        });
    }
};
