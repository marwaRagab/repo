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
        Schema::create('installment_client_cinet', function (Blueprint $table) {
            $table->id();

            $table->string('file_dis_1')->nullable();           //الجهة
            $table->date('file_date_1')->nullable();                      // تاريخ فتح الحساب
            
            $table->string('file_remindes_amount_1')->nullable();            //   الرصيد المتبقى
            $table->string('file_installment_amount_1')->nullable();                 // قيمة القسط
            $table->string('file_debit_amount_1')->nullable();         // قيمة المديونية
            $table->string('file_all_times_1')->nullable();                      // فترة السداد
            $table->string('new_loan_date_1')->nullable();               // اعادة الجدولة
            $table->string('new_loan_amount_1')->nullable();                 // القرض الجديد
            
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
        Schema::dropIfExists('installment_client_cinet');
    }
};
