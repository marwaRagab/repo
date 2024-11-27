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
        Schema::create('installment_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('salary')->nullable();
            $table->string('civil_number')->unique();
            $table->string('phone')->nullable();
            $table->text('notes')->nullable();
            
            $table->enum('status', ['advanced', 'under_inquiry','auditing' ,'car_inquiry','issue_inquiry','archive','accepted','accepted_condition','rejected','inquiry_done'])->default('advanced');
            
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
            
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('regions')->onDelete('set null');
            
            $table->unsignedBigInteger('ministry_id')->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('set null');

            $table->unsignedBigInteger('boker_id')->nullable();
            $table->foreign('boker_id')->references('id')->on('bokers')->onDelete('set null');

            $table->unsignedBigInteger('governorate_id')->nullable();
             $table->foreign('governorate_id')->references('id')->on('governorates')->onDelete('set null');
            
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
        Schema::dropIfExists('installment__clients');
    }
};
