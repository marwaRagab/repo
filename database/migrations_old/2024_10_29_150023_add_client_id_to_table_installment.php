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
        Schema::table('installment', function (Blueprint $table) {
            //
            $table->string('qard_year')->nullable();
            $table->string('qard_place')->nullable();
            $table->string('qard_number')->nullable();
            $table->text('rules')->nullable();
            $table->text('qard_paper')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment', function (Blueprint $table) {
            //
        });
    }
};
