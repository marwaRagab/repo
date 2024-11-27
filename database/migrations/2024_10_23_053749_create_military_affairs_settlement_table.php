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
    
        Schema::create('military_affairs_settlement', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');
             $table->string('type');
             $table->string('cancel_note');
             $table->date('cancel_date');
             $table->date('date');
             $table->float('settle_amount');

             $table->unsignedBigInteger('installment_id')->nullable();
             $table->foreign('installment_id')->references('id')->on('installment')->onDelete('set null');
           
             $table->float('first_amount_settle');
             $table->string('actions');
             $table->string('stop_travel_cancel_request_date');
             $table->string('stop_travel_cancel_reson');

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
        Schema::dropIfExists('military_affairs_settlement');
    }
};
