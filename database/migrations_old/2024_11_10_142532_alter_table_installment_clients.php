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
            //
            $table->text('refuse_reason')->nullable();
            $table->text('accept_condtion')->nullable();
            $table->text('accepted_note')->nullable();
            $table->text('archive_reason')->nullable();
            //accepted_note
            // $table->text('accepted_note')->nullable();
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
