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
        Schema::create('installment_cars', function (Blueprint $table) {
            $table->id();
            
            $table->string('type_car')->nullable();
            $table->string('model_year')->nullable();
            $table->string('average_price')->nullable();
            $table->text('image')->nullable();
          
            $table->unsignedBigInteger('installment_clients_id')->nullable();
            $table->foreign('installment_clients_id')->references('id')->on('installment_clients')->onDelete('set null');

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
        Schema::dropIfExists('installment_cars');
    }
};
