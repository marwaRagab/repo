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
        Schema::create('military_affairs_status', function (Blueprint $table) {
            $table->id();
            $table->string('img_dir')->nullable();
            $table->string('note')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->dateTime('date')->nullable();
            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');
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
        Schema::dropIfExists('military_affairs_status');

    }
};
