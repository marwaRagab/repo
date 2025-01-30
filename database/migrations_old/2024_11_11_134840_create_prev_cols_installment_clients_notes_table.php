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
        Schema::create('prev_cols_installment_clients_notes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notes_id')->nullable();
            $table->foreign('notes_id')->references('id')->on('installment_clients_notes')->onDelete('set null');

            $table->integer('installment_id');
            $table->string('next_date');
            $table->integer('next_date_user_id');
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
        Schema::dropIfExists('prev_cols_installment_clients_notes');
    }
};
