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
        Schema::create('aichats', function (Blueprint $table) {
            $table->id();
            $table->datetime('datetime')->nullable();
            $table->text('received_message')->nullable();
            $table->text('sent_message')->nullable();
            $table->text('id_wa')->nullable();
            $table->integer('timestamp_wa')->nullable();
            $table->string('phone_wa',50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aichats');
    }
};
