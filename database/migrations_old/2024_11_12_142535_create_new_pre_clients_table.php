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
        Schema::create('prev_cols_clients', function (Blueprint $table) {
            $table->id()->unsigned(); // id as bigint unsigned
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->bigInteger('phone');
            $table->float('another_salary', 9, 3);
            $table->string('employed_type', 400);
            $table->tinyInteger('installment_info');
            $table->bigInteger('phone_land');
            $table->bigInteger('phone_work');
            $table->bigInteger('first_person_phone');
            $table->string('first_person_name_1', 400);
            $table->string('first_person_name_2', 400);
            $table->string('area', 400);
            $table->string('block', 400);
            $table->string('street', 400);
            $table->string('jada', 400);
            $table->string('bulding', 400);
            $table->string('floor', 400);
            $table->string('flat_number', 400);
            $table->string('work_address', 400);
            $table->integer('work_place');
            $table->string('img_dir_1', 400);
            $table->string('img_dir_2', 400);
            $table->string('img_dir_3', 400);
            $table->string('img_dir_4', 400);
            $table->string('img_dir_7', 400);
            $table->string('img_dir_8', 400);
            $table->string('img_dir_9', 400);
            $table->tinyInteger('check_sure_bank');
            $table->string('bank_name', 400);
            $table->string('bank_number', 400);
            $table->float('salary', 9, 3);
            $table->string('salary_date', 400);
            $table->float('salary_other_salary', 9, 3);
            $table->string('bank_name_other_salary', 400);
            $table->string('bank_number_other_salary', 400);
            $table->float('sum_of_installments', 9, 3)->nullable();
            $table->integer('ministry');
            $table->integer('ministries_income_id')->nullable();
            $table->string('bank_name_income', 400);
            $table->string('bank_number_income', 400);
            $table->integer('edit_bank_user_id');
            $table->string('easylong_date_start', 400);
            $table->integer('easylong_user_id');
            $table->tinyInteger('easylong_archive');
            $table->integer('easylong_archive_user_id');
            $table->integer('laws_user_id');
            $table->string('cinet_status', 400)->default('nothing');
            $table->integer('cinet_lated_count');
            $table->bigInteger('cinet_date');
            $table->string('cinet_up_pdf', 400);
            $table->integer('lated_count');
            $table->float('lated_amount', 9, 3);
            $table->float('cinet_installment', 9, 3);
            $table->float('cinet_total_lated_amount', 9, 3);
            $table->float('cinet_salary', 9, 3);
            $table->float('cinet_limit', 9, 3);
            $table->string('civil_img_dir', 400);
            $table->integer('edit_client_user_id');
            $table->integer('ministry_2')->nullable();
            $table->float('salary_2', 9, 3)->nullable();
            $table->integer('bank_name_2')->nullable();
            $table->string('bank_number_2', 400)->nullable();
            $table->string('salary_img_2', 400)->nullable();
            $table->integer('ministry_3')->nullable();
            $table->float('salary_3', 9, 3)->nullable();
            $table->integer('bank_name_3')->nullable();
            $table->string('bank_number_3', 400)->nullable();
            $table->string('salary_img_3', 400)->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_clients');
    }
};
