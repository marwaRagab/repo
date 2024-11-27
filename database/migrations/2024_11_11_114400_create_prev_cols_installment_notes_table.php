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
        Schema::create('prev_cols_installment_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('installment_notes_id')->nullable();
            $table->foreign('installment_notes_id')->references('id')->on('installment_notes')->onDelete('set null');
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
            $table->date('next_date')->nullable();
            $table->unsignedBigInteger('next_date_user_id')->nullable();
            $table->foreign('next_date_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_installment_notes');
    }
};
