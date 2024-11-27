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
        Schema::create('military_affairs', function (Blueprint $table) {

            $table->id();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->integer('stop_travel')->nullable();
            $table->integer('stop_salary')->nullable();
            $table->integer('stop_car')->nullable();
            $table->integer('stop_bank')->nullable();
            $table->integer('certificate')->nullable();
            $table->integer('caseProof')->nullable();
            $table->integer('archived')->nullable();
            $table->float('reminder_amount')->nullable();
            $table->integer('is_reminder_amount')->nullable();
            $table->string('madionia_amount');
            $table->string('eqrar_dain_amount');
            $table->string('execute');
            $table->string('payment_done');
            $table->string('law_percent');
            $table->float('excute_actions_check_amount')->nullable();
            $table->float('excute_actions_amount')->nullable();
            $table->float('excute_actions_counter')->nullable();
            $table->integer('checking')->nullable();
            $table->date('excute_actions_last_date_check')->nullable();
            $table->float('place')->nullable();
            $table->integer('issue_id')->nullable();

            $table->unsignedBigInteger('emp_id')->nullable();
            $table->foreign('emp_id')->references('id')->on('users')->onDelete('set null');
            $table->date('date');
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');

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
        Schema::dropIfExists('military_affairs');
    }
};
