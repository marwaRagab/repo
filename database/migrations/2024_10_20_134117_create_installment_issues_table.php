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
        Schema::create('installment_issues', function (Blueprint $table) {
            $table->id();

            $table->string('number_issue')->nullable();
            $table->string('opening_amount')->nullable();
            $table->string('closing_amount')->nullable();
            $table->date('date')->nullable();
            $table->text('image')->nullable();
            
            $table->enum('status', ['open', 'close'])->default('open');
            
            $table->unsignedBigInteger('installment_clients_id')->nullable();
            $table->foreign('installment_clients_id')->references('id')->on('installment_clients')->onDelete('set null');
                  
            $table->string('working_company')->nullable();
  
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
        Schema::dropIfExists('installment_issues');
    }
};
