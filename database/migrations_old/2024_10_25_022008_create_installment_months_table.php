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
        Schema::create('installment_months', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');

            $table->float('amount', 9, 3);
            $table->float('cinet_amount', 9, 3);
             $table->string('internal_amount');
             $table->string('status')->default('not_done');
             $table->string('payment_type')->nullable();
             $table->string('installment_type')->default('installment');
             $table->date('payment_date');
             $table->string('img_dir');
             $table->string('notes');
             $table->tinyInteger('hesab_file');
             $table->date('date');
             $table->date('late_date');
             $table->integer('lated_user_id');
             $table->integer('next_date_user_id');
           

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
        Schema::dropIfExists('installment_months');
    }
};
