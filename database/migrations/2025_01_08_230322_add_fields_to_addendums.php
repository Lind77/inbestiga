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
            $table->text('amount_text')->nullable();
            $table->text('cent_text')->nullable();

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
            $table->dropColumn('amount_text');
            $table->dropColumn('cent_text');
        });
    }
};
