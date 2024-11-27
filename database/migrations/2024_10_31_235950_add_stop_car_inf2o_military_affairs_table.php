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
            $table->string('stop_car_catch')->nullable();
            $table->string('stop_car_police')->nullable();
            $table->string('stop_car_doing')->nullable();
            $table->string('stop_car_police_station')->nullable();
            $table->string('stop_car_finished')->nullable();
            
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
            $table->dropColumn('stop_car_catch');
            $table->dropColumn('stop_car_police');
            $table->dropColumn('stop_car_doing');
            $table->dropColumn('stop_car_police_station');
            $table->dropColumn('stop_car_finished');
        });
    }
};
