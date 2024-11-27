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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();



            $table->unsignedBigInteger('invoice_id')->nullable();
            //$table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');
            $table->float('amount')->flooat(9,3)->nullable();
            $table->float('balance')->flooat(9,3)->nullable();
            $table->tinyInteger('debtor')->default(0);
            $table->tinyInteger('creditor')->default(0);
            $table->string('description');
            $table->string('type');
            $table->string('come_from')->nullable();
            $table->string('payment_type');
            $table->string('knet_code')->nullable();
            $table->integer('sectione_id')->nullable();
            $table->string('pay_for')->nullable();
            $table->string('reciver_name')->nullable();
            $table->string('reciver_phone')->nullable();
            $table->string('payment_file_dir')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
