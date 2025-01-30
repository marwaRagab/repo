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
        Schema::table('transactions_completed', function (Blueprint $table) {
            $table->enum('section_type', ['bank', 'court'])->after('Communication_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions_completed', function (Blueprint $table) {
            $table->dropColumn('section_type');
        });
    }
};
