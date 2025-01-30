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
        Schema::create('transfer_cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->constrained('products_items');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade')->nullable();
            $table->integer('counter')->default(1);
            $table->string('model')->nullable();
            $table->string('company_name')->nullable();
            $table->string('number')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('transfer_cart');
    }
};
