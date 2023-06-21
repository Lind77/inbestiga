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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->string('cell',20)->nullable();
            $table->string('dni')->nullable();
            $table->string('address')->nullable();
            $table->string('university',500)->nullable();
            $table->string('career',500)->nullable();
            $table->string('needs')->nullable();
            $table->string('email', 250)->nullable();
            $table->string('interest')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('attitude')->nullable();   
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('customers');
    }
};
