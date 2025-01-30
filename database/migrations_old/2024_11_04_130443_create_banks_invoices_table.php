<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks_invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');

            $table->float('amount');
            $table->string('payment_type');
            $table->string('description');
            $table->float('balance');
            $table->tinyInteger('debtor')->default(0);
            $table->tinyInteger('creditor')->default(0);
            $table->tinyInteger('checked')->default(0);
            $table->string('come_from')->nullable();
            $table->integer('operation_id')->nullable();
            $table->string('img_dir')->nullable();
            $table->enum('type', ['income','share_capital','expenses','export','advance','income_pending','expenses_pending','debt_pending','returns']);
            $table->string('knet_code')->nullable();
            $table->date('date');



            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');



            $table->timestamps();
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
        Schema::dropIfExists('banks_invoices');
    }
};
