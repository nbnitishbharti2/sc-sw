<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('student_registration_id')->nullable();
            $table->bigInteger('gender_id')->unsigned();
            $table->bigInteger('blood_group_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->string('name',190);
            $table->date('dob');
            $table->string('aadhar_no',20);
            $table->string('cast',190)->nullable();
            $table->string('mobile_no',190)->nullable();
            $table->string('primary_mobile_no',190)->nullable();
            $table->string('email',190)->nullable();
            $table->date('date_of_admission');
            $table->date('date_of_registration')->nullable();
            $table->string('address',255);
            $table->string('city',190);
            $table->string('district',190);
            $table->string('state',190);
            $table->string('country',190);
            $table->integer('zip_code');
            $table->string('father_name',190)->nullable();
            $table->string('father_mobile_no',190)->nullable();
            $table->bigInteger('father_occupation_id')->nullable();
            $table->string('father_education_id')->nullable();
            $table->string('mother_name',190)->nullable();
            $table->string('mother_mobile_no',190)->nullable();
            $table->bigInteger('mother_occupation_id')->nullable();
            $table->string('mother_education_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('student_details', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('blood_group_id')->references('id')->on('blood_groups');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_details');
    }
}