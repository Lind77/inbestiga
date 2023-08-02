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
        Schema::create('assigned_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_activity_id')->nullable();
            $table->foreign('assigned_activity_id')->references('id')->on('assigned_activities')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->date('date')->nullable();
            $table->date('academic_date')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->double('progress')->nullable();
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
        Schema::dropIfExists('assigned_tasks');
    }
};
