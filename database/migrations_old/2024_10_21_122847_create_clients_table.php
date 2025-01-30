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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('civil_number')->unique();
            $table->json('phone_ids')->nullable();
            $table->string('job_type')->nullable();
            $table->string('easylong')->nullable();
            $table->json('address_ids')->nullable();
            $table->json('img_ids')->nullable();
            $table->json('ministry_ids')->nullable();
            $table->json('bank_ids')->nullable();
            $table->string('ipan')->nullable();
            $table->text('location')->nullable();
            $table->text('kwfinder')->nullable();
            $table->text('Longitude')->nullable();
            $table->text('Latitude')->nullable();
            $table->string('qabila')->nullable();

            
            $table->enum('gender', ['male', 'female'])->default('male');
            
            // $table->unsignedBigInteger('bank_id')->nullable();
            // $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');

            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('set null');
            
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id')->references('id')->on('regions')->onDelete('set null');
            
            // $table->unsignedBigInteger('ministry_id')->nullable();
            // $table->foreign('ministry_id')->references('id')->on('ministries')->onDelete('set null');

            $table->unsignedBigInteger('boker_id')->nullable();
            $table->foreign('boker_id')->references('id')->on('bokers')->onDelete('set null');

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');


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
        Schema::dropIfExists('clients');
    }
};
