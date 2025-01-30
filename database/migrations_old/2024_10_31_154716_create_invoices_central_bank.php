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
        Schema::create('invoices_central_bank', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->float('cash')->nullable();
            $table->float('knet')->nullable();
            $table->float('export')->nullable();
            $table->float('share_capital')->nullable();
            $table->float('income')->nullable();
            $table->float('expenses')->nullable();
            $table->float('bank_deposit')->nullable();
            $table->float('purchases')->nullable();
            $table->float('advance')->nullable();
            $table->float('part')->nullable();

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
        Schema::dropIfExists('invoices_central_bank');
    }
};
