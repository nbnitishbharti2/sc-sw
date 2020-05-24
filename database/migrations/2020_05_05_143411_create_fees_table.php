<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('session_id')->unsigned();
            $table->string('fee_name',190);
            $table->string('fee_short_name',190);
            $table->bigInteger('fee_head_id')->unsigned();
            $table->bigInteger('fee_type_id')->unsigned();
            $table->bigInteger('frequency_id')->unsigned()->nullable();
            $table->enum('status',array('Active','InActive'))->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('fees', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('fee_head_id')->references('id')->on('fee_heads')->onDelete('cascade');
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}
