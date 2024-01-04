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
        Schema::table('memorandum_details', function (Blueprint $table) {
            $table->decimal('partial_amount',10,2)->nullable();
            $table->unsignedBigInteger('memorandum_id')->nullable();
            $table->foreign('memorandum_id')->references('id')->on('memorandums')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memorandum_details', function (Blueprint $table) {
            $table->dropColumn('partial_amount');
            $table->dropForeign(['memorandum_id']);
            $table->dropColumn('memorandum_id');
        });
    }
};
