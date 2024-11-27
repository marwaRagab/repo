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
        Schema::table('clients', function (Blueprint $table) {
            //
            $table->string('first_name_ar')->nullable();
            $table->string('second_name_ar')->nullable();
            $table->string('third_name_ar')->nullable();
            $table->string('fourth_name_ar')->nullable();
            $table->string('fifth_name_ar')->nullable();
            $table->string('first_name_en')->nullable();
            $table->string('second_name_en')->nullable();
            $table->string('third_name_en')->nullable();
            $table->string('fourth_name_en')->nullable();
            $table->string('fifth_name_en')->nullable();
            $table->string('salary')->nullable();
            $table->enum('check_on_identity',['0','1'])->default('0');
          

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
};
