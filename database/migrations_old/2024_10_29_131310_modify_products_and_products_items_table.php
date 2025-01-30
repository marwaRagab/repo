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
        // Drop branch_id from products_items table
        Schema::table('products_items', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });

        // Add branch_id to products table
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('number');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add branch_id back to products_items table
        Schema::table('products_items', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
        });

        // Drop branch_id from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
            $table->dropColumn('branch_id');
        });
    }
};
