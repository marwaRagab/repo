<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->boolean('eqrar_dain')->nullable();    // checkbox فى تقديم فى المعاملات المقدمة
            $table->boolean('cinet_enter')->nullable();           // دخول الساينت
            // $table->boolean(column: 'amana_paper')->nullable();       //   وصل امانة
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
