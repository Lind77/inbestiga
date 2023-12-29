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
        Schema::table('addendums', function (Blueprint $table) {
                $table->text('object')->nullable();
                $table->json('clausule')->nullable();
                $table->dropColumn('content');
                $table->dropColumn('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addendums', function (Blueprint $table) {
                $table->dropColumn('object');
                $table->dropColumn('clausule');
                $table->text('content')->nullable();
                $table->double('amount')->nullable();
        });
    }
};
