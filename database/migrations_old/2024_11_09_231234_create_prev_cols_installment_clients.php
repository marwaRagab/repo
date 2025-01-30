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
        Schema::create('prev_cols_installment_clients', function (Blueprint $table) {
            $table->id();
            $table->string('ratio')->nullable();
            $table->string('contract_1')->nullable();
            $table->string('contract_2')->nullable();
            $table->string('contract_cinet_1')->nullable();
            $table->string('contract_cinet_2')->nullable();
            $table->string('prods_recieved_img')->nullable();
            $table->string('reminder_amount')->nullable();
            $table->string('datesend1')->nullable();
            $table->string('datesend2')->nullable();
            $table->string('datesend3')->nullable();
            $table->string('datesend4')->nullable();
            $table->string('mashary')->nullable();
            $table->string('salary_safi_1')->nullable();
            $table->string('cars_img_print')->nullable();
            $table->string('excute_issues_num')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_installment_clients');
    }
};
