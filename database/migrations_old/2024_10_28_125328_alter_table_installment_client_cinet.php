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
        Schema::table('installment_client_cinet', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('installment_clients_id')->nullable();
            $table->foreign('installment_clients_id')->references('id')->on('installment_clients')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_client_cinet', function (Blueprint $table) {
            //
        });
    }
};
