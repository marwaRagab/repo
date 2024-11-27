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
        Schema::create('military_affairs_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');

            $table->string('amount');
            $table->string('check_type')->nullable();
             $table->string('img_dir');
             $table->date('date');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->string('car_type');
            $table->string('car_number')->nullable();
            $table->string('car_catch');
            $table->string('car_price');
            $table->string('car_modal');
            $table->string('car_color')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('military_affairs_amounts');
    }
};
