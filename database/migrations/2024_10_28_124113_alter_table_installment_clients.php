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
        Schema::table('installment_clients', function (Blueprint $table) {
            //
            $table->string('salary_certificate_less_than_5_days')->nullable();
            $table->string('note')->nullable();
            // $table->json('client_working')->nullable();
            // $table->json('installment_client_cinet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_clients', function (Blueprint $table) {
            //
        });
    }
};
