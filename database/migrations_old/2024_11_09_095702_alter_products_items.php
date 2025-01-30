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
            $table->float('cost',9,3)->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->tinyInteger('booked')->default(0);
            $table->float('cash_pack',9,3)->nullable();
            $table->integer('cash_pack_expire_date')->default(0);
            $table->float('discount',9,3)->nullable();
            $table->string('serial_number')->nullable();
            $table->string('serial_number_img')->nullable();
            $table->string('barcode_img_dir')->nullable();
            $table->string('ime_umber')->nullable();
            $table->string('ime_umber_img')->nullable();
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
