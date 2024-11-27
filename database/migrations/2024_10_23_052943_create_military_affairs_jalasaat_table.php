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




        Schema::create('military_affairs_jalasaat', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');
            $table->string('type');
            $table->string('status');
            $table->date('jalsaa_date');
            $table->string('jalasat_alert_img')->nullable();
            $table->date('jalasat_alert_date');
            $table->date('date');
            $table->date('a3lan_jalsa_done_date');
            $table->date('a3lan_paper_date');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('military_affairs_jalasaat');
    }
};
