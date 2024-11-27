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
        Schema::create('invoices_installment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');
            $table->unsignedBigInteger('install_month_id')->nullable();
            $table->foreign('install_month_id')->references('id')->on('installment_months')->onDelete('set null');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->float('amount');
            $table->string('payment_type');
            $table->string('description');
            $table->float('balance');
            $table->tinyInteger('debtor')->default(0);
            $table->tinyInteger('creditor')->default(0);
            $table->float('balance_knet')->nullable();
            $table->float('balance_cash')->nullable();
            $table->float('balance_bank')->nullable();
            $table->string('img')->nullable();
            $table->enum('type', ['income','share_capital','expenses','export','advance','income_pending','expenses_pending','debt_pending','returns']);
            $table->string('knet_code')->nullable();
            $table->date('date');
            $table->string('print_status')->nullable();
            $table->tinyInteger('arch')->default(0);

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
        Schema::dropIfExists('invoices_installment');
    }
};
