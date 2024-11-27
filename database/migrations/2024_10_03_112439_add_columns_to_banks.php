<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_date')->nullable();
            $table->string('iban')->nullable();
            $table->string('branch')->nullable();
            $table->string('authorized_signatory_1')->nullable();
            $table->string('authorized_signatory_2')->nullable();
            $table->string('authorized_signatory_3')->nullable();
            $table->enum('active', ['0', '1'])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn(['bank_account_number', 'bank_account_date' , 'iban' , 'branch', 'authorized_signatory_1' , 'authorized_signatory_2' , 'authorized_signatory_3']);
        });
    }
};
