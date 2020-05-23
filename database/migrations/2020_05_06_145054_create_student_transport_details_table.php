<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentTransportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_transport_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('student_session_detail_id')->unsigned();
            $table->integer('root_id')->unsigned();
            $table->integer('vehicle_type_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('stopage_id')->unsigned();
            $table->integer('amount');
            $table->timestamps();
        });
        Schema::table('student_transport_details', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('student_session_detail_id')->references('id')->on('student_session_details');
            $table->foreign('root_id')->references('id')->on('roots');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('stopage_id')->references('id')->on('stopages');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_transport_details');
    }
}
