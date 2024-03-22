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
        Schema::create('quality_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quality_indicable_id');
            $table->string('quality_indicable_type');
	        $table->string('name')->nullable();
            $table->text('observation')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('quality_indicators');
    }
};
