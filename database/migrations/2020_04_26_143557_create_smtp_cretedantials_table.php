<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpCretedantialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_cretedantials', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->string('email',255);
            $table->string('password',255);
            $table->string('smtp_type',255);
            $table->string('host',6);
            $table->string('port',255);
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
        Schema::dropIfExists('smtp_cretedantials');
    }
}
