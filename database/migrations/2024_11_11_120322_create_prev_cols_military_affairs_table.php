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
        Schema::create('prev_cols_military_affairs', function (Blueprint $table) {
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');
            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->id(); // Auto-increment primary key (id)
            $table->bigInteger('image_date');
            $table->string('image_pdf', 400);
            $table->tinyInteger('command');
            $table->bigInteger('command_date');
            $table->string('command_img', 400);
            $table->tinyInteger('stop_travel_finished');
            $table->bigInteger('stop_travel_finished_date');
            $table->text('stop_travel_finished_img');
            $table->tinyInteger('stop_car_catch');
            $table->bigInteger('stop_car_catch_check_date');
            $table->bigInteger('stop_car_catch_date');
            $table->tinyInteger('stop_car_police');
            $table->tinyInteger('stop_car_doing');
            $table->tinyInteger('stop_salary_request');
            $table->tinyInteger('stop_salary_doing');
            $table->tinyInteger('stop_salary_money');
            $table->bigInteger('stop_salary_money_date');
            $table->string('stop_salary_money_img', 400);
            $table->tinyInteger('stop_salary_part');
            $table->bigInteger('stop_salary_request_date');
            $table->string('stop_salary_request_img', 400);
            $table->bigInteger('stop_salary_doing_date');
            $table->string('stop_salary_doing_img', 400);
            $table->float('stop_salary_money_amount', 9, 3);
            $table->bigInteger('stop_salary_military_judgement_date');
            $table->string('stop_salary_military_judgement_img', 400);
            $table->bigInteger('stop_salary_part_date');
            $table->string('stop_salary_part_img', 400);
            $table->bigInteger('stop_salary_sabah_salem_date');
            $table->string('stop_salary_sabah_salem_img', 400);
            $table->bigInteger('stop_salary_force_affairs_date');
            $table->string('stop_salary_force_affairs_img', 400);
            $table->tinyInteger('stop_salary_military_judgement');
            $table->tinyInteger('stop_salary_sabah_salem');
            $table->tinyInteger('stop_salary_force_affairs');
            $table->tinyInteger('stop_car_request');
            $table->bigInteger('stop_bank_request_date');
            $table->string('stop_bank_request_img', 400);
            $table->bigInteger('stop_car_request_date');
            $table->string('stop_car_request_img', 400);
            $table->tinyInteger('stop_car_info');
            $table->integer('stop_car_car_num');
            $table->string('stop_car_img_print', 400);
            $table->string('stop_car_img_catch', 400);
            $table->bigInteger('stop_car_recieve_date');
            $table->string('stop_car_img', 400);
            $table->tinyInteger('stop_car_finished');
            $table->string('stop_car_img_request', 400);
            $table->tinyInteger('stop_car_archive');
            $table->string('stop_car_archive_type', 200)->default('not_archived');
            $table->text('stop_car_archive_reason');
            $table->integer('stop_car_archive_user_id');
            $table->bigInteger('stop_car_archive_date');
            $table->tinyInteger('stop_car_police_station');
            $table->bigInteger('stop_car_police_station_date');
            $table->string('stop_car_police_station_img', 400);
            $table->integer('stop_car_police_station_user_id');
            $table->tinyInteger('stop_car_amr_hajz');
            $table->bigInteger('stop_car_amr_date');
            $table->string('stop_car_amr_img', 400);
            $table->integer('stop_car_amr_user_id');
            $table->tinyInteger('stop_car_amr_amn_am');
            $table->string('stop_car_amr_amn_am_img', 400);
            $table->bigInteger('stop_car_amr_amn_am_data');
            $table->integer('stop_car_amr_amn_am_user_id');
            $table->tinyInteger('stop_bank_request');
            $table->tinyInteger('stop_bank_command');
            $table->tinyInteger('stop_bank_doing');
            $table->text('bank_archive_note');
            $table->integer('bank_archive_user_id');
            $table->integer('bank_cancel_archive_user_id');
            $table->string('bank_account_status', 400)->default('not_defined');
            $table->string('bank_income_account_status', 400);
            $table->bigInteger('bank_account_file_date');
            $table->string('bank_account_file_dir', 400);
            $table->tinyInteger('catch');
            $table->tinyInteger('catch_command');
            $table->tinyInteger('catch_finished');
            $table->bigInteger('catch_command_date');
            $table->string('catch_command_img', 400);
            $table->bigInteger('catch_finished_date');
            $table->string('catch_finished_img', 400);
            $table->float('tax_value', 9, 3);
            $table->string('tax_img_dir', 400);
            $table->tinyInteger('tax_value_reeived');
            $table->bigInteger('execute_do_date');
            $table->string('execute_do_img', 400);
            $table->string('docs_prtofolio_img', 400);
            $table->bigInteger('doit_jalsa_date');
            $table->bigInteger('jalsaat_alert_paper_date');
            $table->tinyInteger('jalasat');
            $table->string('jalasat_alert_status', 400);
            $table->string('jalasat_alert_img', 400);
            $table->string('jalasat_alert_reason', 400);
            $table->bigInteger('jalasat_alert_date');
            $table->bigInteger('a3lan_jalsa_done_date');
            $table->bigInteger('last_tahseel_date');
            $table->float('lawyer_receive_amount', 9, 3);
            $table->float('excute_actions_amount', 9, 3);
            $table->string('excute_actions_last_img_dir', 400);
            $table->float('excute_actions_lawyer_amount');
            $table->bigInteger('code');
            $table->string('actions_up_img_dir', 400);
            $table->string('archived_img_dir', 400);
            $table->bigInteger('last_sms_time');
            $table->integer('execute_alert_user_id');
            $table->integer('action_user_id');
            $table->string('cancel_stop_travel', 255)->nullable();
            $table->string('cancel_stop_salary', 255)->nullable();
            $table->string('cancel_stop_car', 255)->nullable();
            $table->string('cancel_stop_bank', 255)->nullable();
            $table->integer('stop_travel_cancel_request')->nullable();
            $table->integer('cancel_certificate')->nullable();
            $table->string('certificate_info_book_date', 255)->nullable();
            $table->string('certificate_info_book_img', 255)->nullable();
            $table->string('certificate_export_no', 255)->nullable();
            $table->string('certificate_export_img', 255)->nullable();
            $table->string('certificate_export_date', 255)->nullable();
            $table->text('certificate_export_note')->nullable();
            $table->integer('certificate_export_user_id')->nullable();
            $table->integer('certificate_money')->default(0);
            $table->string('certificate_money_img', 255)->nullable();
            $table->bigInteger('convert_date')->nullable();
            $table->string('caseProof_img', 255);
            $table->string('caseProof_date', 255)->nullable();
            $table->string('stop_bank_banks_date', 255);
            $table->string('stop_bank_banks_amount', 255);
            $table->string('stop_bank_researcher', 255);
            $table->string('stop_bank_banks', 255);
            $table->text('stop_bank_banks_data')->nullable();
            $table->integer('transaction_id')->default(0);
            $table->text('note_transfer')->nullable();
            $table->text('stop_bank_banks_img')->nullable();








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
        Schema::dropIfExists('prev_cols_military_affairs');
    }
};
