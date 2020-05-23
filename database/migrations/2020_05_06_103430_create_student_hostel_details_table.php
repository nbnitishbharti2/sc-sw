<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentHostelDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_hostel_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('st_session_detail_id')->unsigned();
            $table->integer('hostel_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('bade_no');
            $table->integer('amount');
            $table->timestamps();
        });
        Schema::table('student_hostel_details', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('st_session_detail_id')->references('id')->on('student_session_details');
            $table->foreign('hostel_id')->references('id')->on('hostels');
            $table->foreign('room_id')->references('id')->on('rooms');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_hostel_details');
    }
}