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
        Schema::create('orders_files', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('company_id');
            $table->string('img')->nullable();
            $table->float('amount')->nullable();
            $table->string('status')->nullable();
            $table->integer('send_status')->nullable();
            $table->integer('sending_user_id')->nullable();
            $table->date('send_date')->nullable();
            $table->string('place')->nullable();         
            
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
        Schema::dropIfExists('orders_files');
    }
};
