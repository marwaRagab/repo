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
        Schema::create('prev_cols_installment', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');

            $table->string('type', 400)->default('installment');
            $table->integer('client_id');
            $table->integer('kafil_id');
            //  $table->integer('order_id');
            $table->integer('installment_clients');
            $table->float('cost', 9, 3);
            $table->float('selling_price', 9, 3);
            $table->float('org_price', 9, 3);
            //  $table->float('amout', 9, 3);
            $table->float('amount_required', 9, 3);
            //   $table->float('first_amount', 9, 3);
            //    $table->float('total_madionia', 9, 3);
            //   $table->float('extra_first_amount', 9, 3);
            $table->float('total_first_amount', 9, 3);
            //   $table->integer('months');
            $table->float('ratio', 3, 1);
            //  $table->float('installment', 9, 3);
            $table->float('cinet_instal_amount', 9, 3);
            $table->float('intrenal_instal_amount', 9, 3);
            //  $table->enum('status', ['ready', 'approved', 'refused', 'cashier', 'finished', 'installment'])->default('ready');
            //  $table->bigInteger('start_date');
            //   $table->tinyInteger('finished');
            //  $table->text('notes');
            $table->text('note_2');
            //  $table->string('qard_paper', 400);
            $table->tinyInteger('qard_percent');
            $table->tinyInteger('cinet_enter');
            // $table->string('qard_number', 400);
            // $table->string('qard_place', 400);
            // $table->string('qard_year', 400);
            //  $table->string('amana_paper', 400);
            $table->string('installment_bank', 400);
            $table->string('part_paper', 400);
            $table->string('part_latif', 400);
            $table->string('part_paper_number', 400);
            $table->tinyInteger('part_10_dinar');
            $table->string('part_10_dinar_img', 400);
            $table->string('contract_1', 400);
            $table->string('contract_2', 400);
            $table->string('contract_cinet_1', 400);
            $table->string('contract_cinet_2', 400);
            $table->string('prods_recieved_img', 400);
            $table->string('kafil_paper', 400);
            $table->string('kafil_paper_id_face', 400);
            $table->string('kafil_paper_id_back', 400);
            $table->string('kafil_amana', 400);
            $table->string('kafil_dain_paper', 400);
            $table->string('kafil_dain_paper_with', 400);
            $table->string('kafil_notes', 400);
            $table->string('reason', 400);
            //   $table->string('date', 400);
            $table->bigInteger('delivery_date');
            //   $table->tinyInteger('laws')->comment('1 => "yes", 0 => "No"');
            $table->integer('user_id');
            //  $table->integer('finished_user_id');
            $table->integer('cancel_user_id');
            $table->integer('approve_user_id');
            $table->integer('refused_user_id');
            //  $table->bigInteger('last_note_date');
            $table->integer('laws_user_id');
            $table->tinyInteger('please_cancel_eqrar_dain');
            $table->tinyInteger('cancel_eqrar_dain');
            $table->bigInteger('cancel_eqrar_dain_date');
            $table->string('eqrar_dain_cancel_img', 400);
            $table->tinyInteger('paper_received');
            $table->string('paper_received_note', 400);
            $table->bigInteger('paper_received_date');
            $table->string('paper_received_img', 400);
            $table->integer('paper_received_admin_id');
            $table->tinyInteger('paper_received_checked');
            $table->bigInteger('paper_received_checked_date');
            $table->integer('paper_received_checked_admin_id');
            $table->tinyInteger('paper_eqrar_dain_received');
            $table->integer('paper_eqrar_dain_received_user_id');
            $table->integer('paper_eqrar_dain_sender_id');
            $table->bigInteger('paper_eqrar_dain_received_date');
            $table->string('paper_eqrar_dain_received_img', 400);
            $table->integer('arrears_user_id');
            //   $table->tinyInteger('tadqeeq');
            $table->integer('tadqeeq_admin_id');
            $table->bigInteger('tadqeeq_date');
            $table->text('tadqeeq_note');
            //  $table->tinyInteger('manage_review')->default(0);
            $table->integer('manage_review_user_id');
            $table->string('cinet_status', 400);
            //  $table->string('file_number', 400);
            //    $table->integer('lated_count');
            //   $table->float('lated_amount', 9, 3);
            // $table->float('cinet_installment', 9, 3);
            $table->float('cinet_total_lated_amount', 9, 3);
            $table->float('cinet_salary', 9, 3);
            $table->float('cinet_limit', 9, 3);
            $table->tinyInteger('ne3isa');
            $table->tinyInteger('warning');
            $table->string('warning_print_img', 400);
            $table->integer('warning_print_user_id');
            $table->bigInteger('warning_print_date');
            //   $table->bigInteger('eqrardain_date');
            //   $table->float('eqrardain_amount', 9, 3);
            $table->string('laws_paper_print_img', 400);
            $table->integer('warning_upload_user_id');
            $table->bigInteger('warning_upload_date');
            $table->bigInteger('warning_appear_date');
            //   $table->tinyInteger('tadqeeq_archive');
            //  $table->tinyInteger('archive_finished');
            //  $table->tinyInteger('archive_final');
            $table->tinyInteger('archive_received');
            //  $table->integer('tadqeeq_file_number');
            //    $table->string('return_reason', 255)->nullable();
           // $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_installment');
    }
};