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
        Schema::create('eqrars_details', function (Blueprint $table) {
            $table->id();
            $table->string('paper_eqrar_dain_received')->nullable();
            $table->string('paper_received_img')->nullable();
            $table->string('please_cancel_eqrar_dain')->nullable();
            $table->string('paper_received_checked')->nullable();
            $table->string('paper_received_note')->nullable();
            $table->string('paper_eqrar_dain_received_img')->nullable();
            $table->string('paper_received')->nullable();
            $table->string('cancel_eqrar_dain')->nullable();
            $table->string('eqrar_dain_cancel_img')->nullable();
            $table->dateTime('paper_received_checked_date')->nullable();
            $table->dateTime('paper_eqrar_dain_received_date')->nullable();
            $table->dateTime('paper_received_date')->nullable();
            $table->dateTime('cancel_eqrar_dain_date')->nullable();
            $table->unsignedBigInteger('paper_eqrar_dain_sender_id')->nullable();
            $table->foreign('paper_eqrar_dain_sender_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('paper_eqrar_dain_received_user_id')->nullable();
            $table->foreign('paper_eqrar_dain_received_user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('paper_received_admin_id')->nullable();
            $table->foreign('paper_received_admin_id')->references('id')->on('users')->onDelete('set null');
            // Foreign key constraints for created_by and updated_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eqrars_details');
    }
};
