<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_name',255);
            $table->string('school_short_name',255);
            $table->longText('address');
            $table->string('mobile_no',25);
            $table->string('mobile_no2',25);
            $table->string('phone_no',25);
            $table->integer('pin_code'); 
            $table->string('city',25);
            $table->string('state',25);
            $table->string('country',25);
            $table->string('country_code',25);
            $table->string('country_phone_code',25);
            $table->string('currency',25);
            $table->string('web_site',255);
            $table->string('email',255);
            $table->string('logo',255);
            $table->string('water_mark',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_details');
    }
}
