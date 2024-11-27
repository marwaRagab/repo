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
            $table->date('stop_travel_finished_date')->nullable();
            $table->date('stop_travel_finished_img')->nullable();
            $table->date('execute_do_img')->nullable();
            $table->date('stop_car_recieve_date')->nullable();
            
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
            $table->dropColumn('stop_travel_finished_date');
            $table->dropColumn('stop_travel_finished_img');
            $table->dropColumn('execute_do_img');
            $table->dropColumn('stop_car_recieve_date');
        });
    }
};
