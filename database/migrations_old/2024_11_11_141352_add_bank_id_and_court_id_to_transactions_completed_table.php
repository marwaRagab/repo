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
        Schema::table('transactions_completed', function (Blueprint $table) {
            $table->unsignedBigInteger('court_id')->nullable();
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('cascade');

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_completed', function (Blueprint $table) {
            //
        });
    }
};
