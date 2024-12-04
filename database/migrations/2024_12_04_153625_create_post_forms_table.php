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
        Schema::create('post_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_formable_id');
            $table->string('post_formable_type');
            $table->unsignedBigInteger('comunication_channel_id')->nullable();
            $table->foreign('comunication_channel_id')->references('id')->on('comunication_channels')->nullOnDelete();
            $table->unsignedBigInteger('study_place_id')->nullable();
            $table->foreign('study_place_id')->references('id')->on('study_places')->nullOnDelete();
            $table->unsignedBigInteger('marketing_source_id')->nullable();
            $table->foreign('marketing_source_id')->references('id')->on('marketing_sources')->nullOnDelete();
            $table->unsignedBigInteger('hire_factor_id')->nullable();
            $table->foreign('hire_factor_id')->references('id')->on('hire_factors')->nullOnDelete();
            $table->unsignedBigInteger('contract_mode_id')->nullable();
            $table->foreign('contract_mode_id')->references('id')->on('contract_modes')->nullOnDelete();
            $table->unsignedBigInteger('academic_situation_id')->nullable();
            $table->foreign('academic_situation_id')->references('id')->on('academic_situations')->nullOnDelete();
            $table->unsignedBigInteger('professional_status_id')->nullable();
            $table->foreign('professional_status_id')->references('id')->on('professional_statuses')->nullOnDelete();
            $table->unsignedBigInteger('participation_id')->nullable();
            $table->foreign('participation_id')->references('id')->on('participations')->nullOnDelete();
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
        Schema::dropIfExists('post_forms');
    }
};
