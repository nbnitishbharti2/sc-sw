<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleRootMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_root_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('root_id')->unsigned();
            $table->integer('vehicle_type_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('vehicle_root_maps', function($table){
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
        Schema::dropIfExists('vehicle_root_maps');
    }
}
