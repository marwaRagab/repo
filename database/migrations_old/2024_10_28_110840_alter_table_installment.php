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
        Schema::table('installment_clients', function (Blueprint $table) {
            $table->string('cinet_total_income')->nullable();                //اجمالى الدخل
            $table->string('cinet_installments_total')->nullable();                   //مجموع الاقساط
            $table->string('total_lated_installments')->nullable();      //الاقساط المتأخرة
            $table->string('cinet_amount_limit')->nullable();                 //القسط المسموح
            $table->string('cinet_amount_limit_safi')->nullable();          //ليمت صافى الراتب
            $table->string('cint_count_files')->nullable();                 //     عدد الملفات
            $table->string('cinet_pdf')->nullable();               //        ملف الساينت
            $table->string('upload_img_2')->nullable();                 //صورة مدنية

            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');

            $table->unsignedBigInteger('installment_client_cinet_id')->nullable();
            $table->foreign('installment_client_cinet_id')->references('id')->on('installment_client_cinet')->onDelete('set null');




        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_clients', function (Blueprint $table) {
            //
        });
    }
};
