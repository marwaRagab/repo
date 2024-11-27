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

        Schema::create('installment', function (Blueprint $table) {
            $table->id();


            $table->string('status')->nullable();
            $table->string('amount')->nullable();
            $table->string('total_madionia')->nullable();
            $table->string('extra_first_amount')->nullable();
            $table->string('installment')->nullable();
            $table->string('eqrardain_amount')->nullable();
            $table->dateTime('eqrardain_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('finished')->nullable();
            $table->string('months')->nullable();
            $table->string('laws')->nullable();
            $table->string('lated_count')->nullable();
            $table->string('manage_review')->nullable();
            $table->string('lated_amount')->nullable();
            $table->string('archive_finished')->nullable();
            $table->string('archive_final')->nullable();
            $table->string('file_number')->nullable();
            $table->string('tadqeeq_archive')->nullable();
            $table->string('tadqeeq')->nullable();
            $table->string('tadqeeq_file_number')->nullable();

            // $table->unsignedBigInteger('eqrars_id')->nullable();
            // $table->foreign('eqrars_id')->references('id')->on('eqrars_details')->onDelete('set null');

            $table->date('date')->nullable();

            $table->unsignedBigInteger('installment_clients')->nullable();
            $table->foreign('installment_clients')->references('id')->on('installment_clients')->onDelete('set null');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

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
        //
        Schema::dropIfExists('installment');
    }
};
