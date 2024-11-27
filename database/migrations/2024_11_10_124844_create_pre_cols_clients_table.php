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

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('img_dir1')->nullable();
            $table->string('img_dir2')->nullable();
            $table->string('img_dir3')->nullable();
            $table->string('img_dir4')->nullable();
            $table->string('img_dir7')->nullable();
            $table->string('img_dir8')->nullable();
            $table->string('img_dir9')->nullable();
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat_number')->nullable();
            $table->string('street')->nullable();
            $table->string('jada')->nullable();
            $table->string('work_address')->nullable();
            $table->string('work_place')->nullable();
            $table->string('check_sure_bank')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_number')->nullable();
            $table->date('salary_date')->nullable();
            $table->string('salary_other_salary')->nullable();
            $table->string('bank_name_other_salary')->nullable();
            $table->string('bank_number_other_salary')->nullable();
            $table->string('sum_of_installments')->nullable();
            $table->string('ministries_income_id')->nullable();
            $table->string('bank_name_income')->nullable();
            $table->string('bank_number_income')->nullable();
            $table->string('edit_bank_user_id')->nullable();
            $table->string('created_date')->nullable();
            $table->string('easylong_date_start')->nullable();
            $table->integer('edit_bank_user_id')->nullable();
            $table->integer('easylong_user_id')->nullable();
            $table->string('easylong_archive')->nullable();
            $table->string('easylong_archive')->nullable();
            $table->integer('easylong_archive_user_id')->nullable();
            $table->string('cinet_status')->nullable();
            $table->integer('cinet_lated_count')->nullable();
            $table->date('cinet_date')->nullable();
            $table->string('cinet_up_pdf')->nullable();
            $table->string('cinet_date')->nullable();
            $table->string('lated_amount')->nullable();
            $table->string('lated_count')->nullable();
            $table->string('cinet_installment')->nullable();
            $table->string('cinet_total_lated_amount')->nullable();
            $table->string('cinet_salary')->nullable();
            $table->string('cinet_limit')->nullable();
            $table->string('civil_img_dir')->nullable();
            $table->integer('edit_client_user_id')->nullable();
            $table->string('ministry_2')->nullable();
            $table->string('salary_2')->nullable();
            $table->string('bank_name_2')->nullable();
            $table->string('salary_img_2')->nullable();
            $table->string('ministry_3')->nullable();
            $table->string('salary_3')->nullable();
            $table->string('bank_name_3')->nullable();
            $table->string('salary_img_3')->nullable();
            $table->enum('check_on_identity',[0,1])->nullable();
            $table->integer('laws_user_id')->nullable();
            $table->string('phone_land')->nullable();
            $table->string('phone_work')->nullable();
            $table->string('first_person_phone')->nullable();
            $table->string('employed_type')->nullable();
            $table->string('another_salary')->nullable();
            $table->string('installment_info')->nullable();
            $table->string('first_person_name_1')->nullable();
            $table->string('first_person_name_2')->nullable();
            $table->string('phone')->nullable();
            $table->integer('ministry')->nullable();
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
