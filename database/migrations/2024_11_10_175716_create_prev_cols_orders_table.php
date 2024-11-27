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
        Schema::create('prev_cols_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orders_id')->nullable();
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('set null');
            $table->float('price',9,3)->nullable();
            $table->float('price_qabila',9,3)->nullable();
            $table->float('final_price',9,3)->nullable();
            $table->enum('payment_type',['cash', 'knet','installment'])->nullable();
            $table->date('payment_date')->nullable();
            $table->float('cash',9,3)->nullable();
            $table->float('knet',9,3)->nullable();
            $table->float('old_price',9,3)->nullable();
            $table->string('civil_id')->nullable();
            $table->string('status')->nullable();
            $table->string('sending')->nullable();
            $table->date('sending_date')->nullable();
            $table->tinyInteger('updated')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('archived')->nullable();
            $table->date('delivary_date')->nullable();
            $table->string('delivary_time_start')->nullable();
            $table->string('delivary_time_end')->nullable();
            $table->text('delivary_note')->nullable();
            $table->string('knet_code')->nullable();
            $table->unsignedBigInteger('client_received')->nullable();
            $table->foreign('client_received')->references('id')->on('users')->onDelete('set null');
            $table->tinyInteger('driver_delivery')->nullable();
            $table->tinyInteger('driver_id')->nullable();
            $table->unsignedBigInteger('pay_user_id')->nullable();
            $table->foreign('pay_user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('client_received_user_id')->nullable();
            $table->foreign('client_received_user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('installment_user_id')->nullable();
            $table->foreign('installment_user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('user_cancel_id')->nullable();
            $table->foreign('user_cancel_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('archive_user_id')->nullable();
            $table->foreign('archive_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_orders');
    }
};
