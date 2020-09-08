<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelFeeMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel_fee_months', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('hostel_fee_id')->unsigned();
            $table->bigInteger('month_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('hostel_fee_months', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('hostel_fee_id')->references('id')->on('hostel_fees')->onDelete('cascade');
            $table->foreign('month_id')->references('id')->on('months')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hostel_fee_months');
    }
}
