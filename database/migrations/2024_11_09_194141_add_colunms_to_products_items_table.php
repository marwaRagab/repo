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
        Schema::table('products_items', function (Blueprint $table) {
            //
            //  $table->unsignedBigInteger('branch_id')->nullable();
            //$table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
         //   $table->float('cash_pack')->float(9, 3)->nullable();
          //  $table->float('discount')->float(3, 1)->nullable();
         //   $table->string('serial_number')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_items', function (Blueprint $table) {
            //
            $table->dropColumn('branch_id');
            $table->dropColumn('cash_pack');
            $table->dropColumn('discount');
            $table->dropColumn('serial_number');

        });
    }
};