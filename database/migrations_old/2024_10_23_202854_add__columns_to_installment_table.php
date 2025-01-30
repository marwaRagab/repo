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
        Schema::table('installment', function (Blueprint $table) {
            //
            $table->string('return_reason')->nullable();
            $table->date('last_note_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment', function (Blueprint $table) {
            //
            $table->dropColumn('return_reason');
            $table->dropColumn('last_note_date');
        });
    }
};
