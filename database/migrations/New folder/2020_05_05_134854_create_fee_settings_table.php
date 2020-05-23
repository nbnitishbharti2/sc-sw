<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('school_fee_frequency')->unsigned();
            $table->bigInteger('transport_fee_frequency')->unsigned();
            $table->bigInteger('hostel_fee_frequency')->unsigned();
            $table->enum('emand_slip_generation_mode',array('Auto','Manual'))->default('Auto');
            $table->enum('demand_slip_generation_message',array('Yes','No'))->default('No');
            $table->enum('demand_slip_reminder_message',array('Yes','No'))->default('No');
            $table->date('reminder_date_time');
            $table->enum('payment_message',array('Yes','No'))->default('No');
            $table->timestamps();
        });
        Schema::table('fee_settings', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('school_fee_frequency')->references('id')->on('fee_frequencies')->onDelete('cascade');
            $table->foreign('transport_fee_frequency')->references('id')->on('fee_frequencies');
            $table->foreign('hostel_fee_frequency')->references('id')->on('fee_frequencies');
        });
    }
      


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_settings');
    }
}
