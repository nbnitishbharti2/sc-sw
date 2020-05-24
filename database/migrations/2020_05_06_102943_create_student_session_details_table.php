<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentSessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_session_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->bigInteger('section_id')->unsigned();
            $table->bigInteger('student_detail_id')->unsigned();
            $table->string('admission_no');
            $table->string('roll_no');
            $table->date('date_of_admission');
            $table->integer('siblings');
            $table->enum('type',array('Admission','Registered','Permoted'))->default('Permoted');
            $table->enum('transport',array('Yes','No'))->default('No');
            $table->enum('hostel',array('Yes','No'))->default('No');
            $table->bigInteger('register_by')->nullable();
            $table->bigInteger('admission_by');
            $table->timestamps();
        });
        Schema::table('student_session_details', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('student_detail_id')->references('id')->on('student_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_session_details');
    }
}
 