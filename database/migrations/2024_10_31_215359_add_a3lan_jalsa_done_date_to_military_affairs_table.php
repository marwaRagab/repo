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
            //
            $table->string('a3lan_jalsa_done_date')->nullable();

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
            //
            $table->dropColumn('a3lan_jalsa_done_date');
        });
    }
};
