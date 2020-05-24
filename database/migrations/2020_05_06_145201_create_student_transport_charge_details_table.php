<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTransportChargeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_transport_charge_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('st_session_detail_id')->unsigned();
            $table->bigInteger('st_transport_details_id')->unsigned();
            $table->bigInteger('fee_id')->unsigned();
            $table->bigInteger('fee_type_td')->unsigned();
            $table->bigInteger('fee_head_id')->unsigned();
            $table->integer('amount');
            $table->timestamps();
        });
        Schema::table('student_transport_charge_details', function($table){
           $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('st_session_detail_id')->references('id')->on('student_session_details');
            $table->foreign('st_transport_details_id')->references('id')->on('student_transport_details');
            $table->foreign('fee_id')->references('id')->on('fees');
            $table->foreign('fee_type_td')->references('id')->on('fee_types');
            $table->foreign('fee_head_id')->references('id')->on('fee_heads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_transport_charge_details');
    }
}
