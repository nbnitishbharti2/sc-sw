<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeForClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_for_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->bigInteger('fee_id')->unsigned();
            $table->integer('class_id')->unsigned();
            $table->integer('charge');
            $table->timestamps();
        });
         Schema::table('fee_for_classes', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_for_classes');
    }
}
