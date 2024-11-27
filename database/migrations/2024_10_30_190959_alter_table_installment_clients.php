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
        Schema::table('installment_clients', function (Blueprint $table) {
            //

            $table->enum('status', [
                'advanced',
                'under_inquiry',
                'auditing',
                'car_inquiry',
                'issue_inquiry',
                'archive',
                'accepted',
                'accepted_condition',
                'rejected',
                'inquiry_done',
                'transaction_submited',
                'transaction_accepted',
                'transaction_refused',
                'submit_archive',
                'accepted_archive',
            ])->default('advanced');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('installment_clients', function (Blueprint $table) {
            //
        });
    }
};
