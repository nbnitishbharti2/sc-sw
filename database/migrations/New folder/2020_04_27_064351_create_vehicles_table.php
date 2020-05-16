<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('driver_name', 190);
            $table->string('driver_contact_no', 190);
            $table->string('helper_name', 190);
            $table->string('helper_contact_no', 190);
            $table->integer('vehicle_type_id')->unsigned();
            $table->string('vehicle_no', 15);
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('vehicles', function($table){
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
