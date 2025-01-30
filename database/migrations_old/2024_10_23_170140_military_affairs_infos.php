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
        //
        Schema::create('military_affairs_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('found')->nullable();
            $table->string('note')->nullable();
            $table->string('replay')->nullable();
            $table->dateTime('date')->nullable();
            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            $table->unsignedBigInteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('set null');

            // Foreign key constraints for created_by and updated_by
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('military_affairs_infos');

    }
};
