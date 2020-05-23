<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAdmissionPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_admission_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('student_detail_id')->unsigned();
            $table->bigInteger('fee_id')->unsigned();
            $table->bigInteger('fee_type_td')->unsigned();
            $table->bigInteger('fee_head_id')->unsigned();
            $table->bigInteger('st_adm_trans_id')->unsigned();
            $table->integer('amount');
            $table->timestamps();
        }); 
            
        Schema::table('student_admission_payments', function($table){
           $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('student_detail_id')->references('id')->on('student_details');
            $table->foreign('fee_id')->references('id')->on('fees');
            $table->foreign('fee_type_td')->references('id')->on('fee_types');
            $table->foreign('fee_head_id')->references('id')->on('fee_heads');
            $table->foreign('st_adm_trans_id')->references('id')->on('student_admission_transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_admission_payments');
    }
}
