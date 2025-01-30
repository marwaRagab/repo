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
        Schema::create('transfer_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_branch_id');
            $table->unsignedBigInteger('to_branch_id');
            $table->string('transport_img_dir', 400);
            $table->string('received_img_dir', 400)->nullable();
            $table->tinyInteger('received')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transport_id');
            $table->unsignedBigInteger('received_user_id')->nullable();
            $table->bigInteger('date');
            $table->bigInteger('received_date')->nullable();

            $table->foreign('from_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('to_branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('received_user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('transfer_branches');
    }
};
