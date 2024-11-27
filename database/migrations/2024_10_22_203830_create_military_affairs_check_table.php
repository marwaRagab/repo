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
        /*
        Table military_affairs_check {
  id int [pk, increment]  
  military_affairs_id int [ref: > military_affairs.id]
  amount varchar [not null]
  check_number varchar [not null]
  img_dir varchar [not null]
   deposit varchar [ null]
   deposit_date varchar [ null] 
   deposit_img varchar [ null] 
   deposit_user_id int [ref: > users.id]
   created_by  int [ref: > users.id]
  updated_by  int [ref: > users.id]
  created_at timestamp
  updated_at timestamp
  deleted_at timestamp
        */
        Schema::create('military_affairs_check', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('military_affairs_id')->nullable();
            $table->foreign('military_affairs_id')->references('id')->on('military_affairs')->onDelete('set null');

            $table->string('amount');
            $table->string('check_number');
            $table->string('img_dir');
            $table->string('deposit')->nullable();
            $table->string('deposit_date')->nullable();
            $table->string('deposit_img')->nullable();

            $table->unsignedBigInteger('deposit_user_id')->nullable();
            $table->foreign('deposit_user_id')->references('id')->on('users')->onDelete('set null');
            
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
        Schema::dropIfExists('military_affairs_check');
    }
};
