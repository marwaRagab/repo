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
        Schema::table('users', function (Blueprint $table) {
            //

               // Foreign key referencing roles table
            //  $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            
             // Foreign key referencing Branches table
           //   $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            
          // Foreign key constraints for created_by and updated_by
          $table->unsignedBigInteger('created_by')->nullable();
          $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

          $table->unsignedBigInteger('updated_by')->nullable();
          $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
