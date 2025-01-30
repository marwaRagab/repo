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
        Schema::create('prev_cols_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_items_id')->nullable();
            $table->foreign('order_items_id')->references('id')->on('order_items')->onDelete('set null');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->unsignedBigInteger('products_items_id')->nullable();
            $table->foreign('products_items_id')->references('id')->on('products_items')->onDelete('set null');
            $table->float('price_qabila',9,3)->nullable();
            $table->float('org_price',9,3)->nullable();
            $table->float('cash_pack',9,3)->nullable();
            $table->bigInteger('cash_pack_expire_date')->nullable();
            $table->float('discount',9,3)->nullable();
            $table->float('final_price',9,3)->nullable();
            $table->float('price_discount',9,3)->nullable();
            $table->integer('counter')->nullable();
            $table->integer('canceled_counter')->nullable();
            $table->tinyInteger('cancel')->nullable();
            $table->text('reason')->nullable();
            $table->tinyInteger('updated')->nullable();
            $table->tinyInteger('client_received')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prev_cols_order_items');
    }
};
