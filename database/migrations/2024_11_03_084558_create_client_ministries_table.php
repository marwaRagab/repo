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
        Schema::create('client_ministries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->on('ministries')->references('id')->onDelete('set null');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->on('clients')->references('id')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_ministries');
    }
};
