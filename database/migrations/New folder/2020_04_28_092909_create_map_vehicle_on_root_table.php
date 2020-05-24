<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapVehicleOnRootTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map_vehicle_on_root', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('root_id')->unsigned();
            $table->integer('vehicle_type_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('map_vehicle_on_root', function($table){
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
        Schema::dropIfExists('map_vehicle_on_root');
    }
}
