<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRegistrationPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('student_registration_payments', function ($table) {
        $table->bigInteger('st_regm_id')->unsigned()->after('st_reg_id');//the after method is optional. 
        });
         Schema::table('student_registration_payments', function($table){ 
            $table->foreign('st_regm_id')->references('id')->on('student_registration_maps'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         
    }
}
