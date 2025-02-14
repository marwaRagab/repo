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
        Schema::table('client_imgs', function (Blueprint $table) {
            //
            $table->string('name')->nullable();
            $table->enum('type',['contract','personal','working'])->default('personal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_imgs', function (Blueprint $table) {
            //
        });
    }
};
