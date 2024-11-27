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
        Schema::table('orders_files', function (Blueprint $table) {
            //
            $table->string('received')->default(0)->nullable();

            $table->unsignedBigInteger('received_user_id')->nullable();
            $table->foreign('received_user_id')->references('id')->on('users')->onDelete('set null');



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
