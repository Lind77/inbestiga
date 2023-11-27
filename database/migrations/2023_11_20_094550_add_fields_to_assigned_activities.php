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
            $table->dropForeign(['delivery_id']);
            $table->dropColumn('delivery_id');
            $table->unsignedBigInteger('assigned_activitiable_id');
            $table->string('assigned_activitiable_type'); 
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
            $table->dropColumn('assigned_activitiable_id');
            $table->dropColumn('assigned_activitiable_type'); 
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
        });
    }
};
