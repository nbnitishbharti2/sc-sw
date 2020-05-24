<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsCretedantialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_cretedantials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name',255);
            $table->string('password',255);
            $table->string('api_key',255);
            $table->string('sender_id',6);
            $table->string('sms_gateway_url',255);
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
        Schema::dropIfExists('sms_cretedantials');
    }
}
