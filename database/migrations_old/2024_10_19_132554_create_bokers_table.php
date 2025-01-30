<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bokers', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('phone')->nullable();
            
            $table->text('percentage')->nullable();
            $table->enum('percentage_amount', ['amount', 'percentage'])->default('percentage');     
            
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
        Schema::dropIfExists('bokers');
    }
};
