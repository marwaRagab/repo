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
        Schema::table('military_affairs_notes', function (Blueprint $table) {
            //
            $table->string('notes_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('military_affairs_notes', function (Blueprint $table) {
            //
            $table->dropColumn('notes_type');
        });
    }
};
