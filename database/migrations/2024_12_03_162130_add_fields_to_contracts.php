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
        Schema::table('contracts', function (Blueprint $table) {
            $table->string('code')->nullable();
            $table->date('registration_date')->nullable();
            $table->unsignedBigInteger('thesis_type_id')->nullable();
            $table->foreign('thesis_type_id')->references('id')->on('thesis_types')->nullOnDelete();     
            $table->unsignedBigInteger('thesis_degree_id')->nullable();
            $table->foreign('thesis_degree_id')->references('id')->on('thesis_degrees')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn('code'); 
            $table->dropColumn('registration_date'); 
            $table->dropForeign(['thesis_type_id']);
            $table->dropColumn('thesis_type_id'); 
            $table->dropForeign(['thesis_degree_id']);
            $table->dropColumn('thesis_degree_id'); 
        });
    }
};
