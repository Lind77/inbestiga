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
        Schema::table('external_vouchers', function (Blueprint $table) {
           $table->double('external_discount')->nullable();
           $table->double('internal_discount')->nullable();
           $table->double('partial_amount')->nullable();
           $table->double('taxes')->nullable();
           $table->double('net_profit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_vouchers', function (Blueprint $table) {
            $table->dropColumn('external_discount'); 
            $table->dropColumn('internal_discount'); 
            $table->dropColumn('partial_amount'); 
            $table->dropColumn('taxes'); 
            $table->dropColumn('net_profit'); 
        });
    }
};
