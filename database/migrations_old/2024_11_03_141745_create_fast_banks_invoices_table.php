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
        Schema::create('fast_banks_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('amount')->flooat(9,3)->nullable();
            $table->string('balance')->flooat(9,3)->nullable();
            $table->string('balance_bank')->flooat(9,3)->nullable();
            $table->string('balance_cash')->flooat(9,3)->nullable();
            $table->string('balance_client')->flooat(9,3)->nullable();
            $table->integer('debtor')->nullable();
            $table->integer('creditor')->nullable();
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_date')->nullable();
            $table->string('img_dir_1')->nullable();
            $table->string('img_dir_2')->nullable();
            $table->string('img_dir_3')->nullable();
            $table->string('pay_for')->nullable();
            $table->string('reciver_name')->nullable();
            $table->string('reciver_phone')->nullable();
            $table->string('cat_id')->nullable();
            $table->string('datebasheer')->nullable();

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            $table->softDeletes();
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
        Schema::dropIfExists('fast_banks_invoices');
    }
};
