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
        Schema::table('military_affairs', function (Blueprint $table) {
            $table->string('stop_salary_request')->nullable();
            $table->string('stop_salary_doing')->nullable();
            $table->string('stop_salary_money')->nullable();
            $table->string('stop_salary_part')->nullable();
            $table->string('stop_salary_cancel_request')->nullable();
            $table->string('stop_salary_cancel')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('military_affairs', function (Blueprint $table) {
            $table->dropColumn('stop_salary_request');
            $table->dr('stop_salary_doing');
            $table->string('stop_salary_money')->nullable();
            $table->string('stop_salary_part')->nullable();
            $table->string('stop_salary_cancel_request')->nullable();
            $table->string('stop_salary_cancel')->nullable();

        });
    }
};
