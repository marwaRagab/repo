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
        Schema::table('installment_client_cinet', function (Blueprint $table) {
            //

          //  $table->dropColumn('cinet_total_income');                //اجمالى الدخل
          //  $table->dropColumn('cinet_installments_total');                   //مجموع الاقساط
          //  $table->dropColumn('total_lated_installments');      //الاقساط المتأخرة
          //  $table->dropColumn('cinet_amount_limit');                 //القسط المسموح
          //  $table->dropColumn('cinet_amount_limit_safi');          //ليمت صافى الراتب
          //  $table->dropColumn('cint_count_files');                 //     عدد الملفات
          //  $table->dropColumn('cinet_pdf');               //        ملف الساينت
          //  $table->dropColumn('upload_img_2');

            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_client_cinet', function (Blueprint $table) {
            //
        });
    }
};
