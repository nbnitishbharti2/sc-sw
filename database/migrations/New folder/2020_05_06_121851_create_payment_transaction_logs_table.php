<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTransactionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('expance_head_id')->nullable();
            $table->bigInteger('income_head_id')->nullable();
            $table->bigInteger('transaction_type_id')->nullable();
            $table->integer('amount');
            $table->integer('discount');
            $table->enum('flow',array('Cr','Dr'))->default('Cr');
            $table->timestamps();
        });
        Schema::table('payment_transaction_logs', function($table){
           $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transaction_logs');
    }
}
