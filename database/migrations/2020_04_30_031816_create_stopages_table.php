<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStopagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stopages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->string('stopage_name', 190);
            $table->integer('root_id')->unsigned();
            $table->integer('vehicle_type_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('charge');
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('stopages', function($table){
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('root_id')->references('id')->on('roots')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stopages');
    }
}
