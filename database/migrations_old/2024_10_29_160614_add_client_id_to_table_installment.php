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
        Schema::table('installment', function (Blueprint $table) {
            //

            $table->string('cost_install')->nullable();                //مبلغ الموافقة
            $table->string('cost_product')->nullable(); 
            $table->string('part')->nullable();                          //المقدم
            $table->string('extra_part')->nullable();
            $table->string('total_part')->nullable();
            $table->string('final_installment_amount')->nullable();      //المبلغ المقسط 
            $table->string('count_months')->nullable();                 //عدد الاقساط
            $table->string('total')->nullable();                         //     اجمالى المبلغ المقسط
            $table->string('monthly_amount')->nullable();               //        القسط الشهرى
            $table->string('cinet_installment')->nullable();                 //قسط الساينت
            $table->string('intrenal_installment')->nullable();           //القسط الداخلى
            $table->date('start_date')->nullable();                      //بداية اول قسط
            $table->enum('payment_type',['cash','knet'])->default('cash');   
            // $table->string('qarareldin_total')->nullable();             
            // $table->text('notes')->nullable();           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment', function (Blueprint $table) {
            //
        });
    }
};
