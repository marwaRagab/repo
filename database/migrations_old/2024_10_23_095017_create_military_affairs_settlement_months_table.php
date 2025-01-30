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
        Schema::create('military_affairs_settlement_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settle_id')->nullable();
            $table->foreign('settle_id')->references('id')->on('military_affairs_settlement')->onDelete('set null');
           
            $table->float('amount');    

            $table->unsignedBigInteger('installment_id')->nullable();
             $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');
           
            $table->string('payment_type');
            $table->string('installment_type');
            $table->text('pay_details');
            $table->text('payment_date');
            $table->text('date');
            $table->text('img');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('military_affairs_settlement_months');
    }
};
