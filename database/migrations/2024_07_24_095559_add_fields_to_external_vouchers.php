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
            $table->double('itf')->nullable();
            $table->string('customer_name',100)->nullable();
            $table->string('payment_method_name',50)->nullable();
            $table->unsignedBigInteger('cpe_id')->nullable();
            $table->foreign('cpe_id')->references('id')->on('cpes')->nullOnDelete();
            $table->unsignedBigInteger('earn_type_id')->nullable();
            $table->foreign('earn_type_id')->references('id')->on('earn_types')->nullOnDelete();
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
            $table->dropColumn('itf');
            $table->dropColumn('customer_name');
            $table->dropColumn('payment_method_name');
            $table->dropForeign(['cpe_id']);
            $table->dropColumn('cpe_id');  
            $table->dropForeign(['earn_type_id']);
            $table->dropColumn('earn_type_id');  
        });
    }
};
