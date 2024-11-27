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
        Schema::table('military_affairs_amounts', function (Blueprint $table) {
            //
            $table->integer('military_affairs_check_id')->default(0)->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('military_affairs_amounts', function (Blueprint $table) {
            //
            $table->dropColumn('military_affairs_check_id');

        });
    }
};
