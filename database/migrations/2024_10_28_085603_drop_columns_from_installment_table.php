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
        Schema::table('installment', function (Blueprint $table) {
            $table->dropColumn([
                'cost_install',
                'part',
                'final_installment_amount',
                'count_months',
                'count_months_without',
                'total',
                'monthly_amount',
                'cinet_installment',
                'intrenal_installment',
                'start_date',
                'eqrar_dain',
                'cinet_enter'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment', function (Blueprint $table) {
            $table->string('cost_install')->nullable();
            $table->string('part')->nullable();
            $table->string('final_installment_amount')->nullable();
            $table->string('count_months')->nullable();
            $table->string('count_months_without')->nullable();
            $table->string('total')->nullable();
            $table->string('monthly_amount')->nullable();
            $table->string('cinet_installment')->nullable();
            $table->string('intrenal_installment')->nullable();
            $table->string('start_date')->nullable();
            $table->boolean('eqrar_dain')->nullable();    
            $table->boolean('cinet_enter')->nullable();           
        });
    }
};
