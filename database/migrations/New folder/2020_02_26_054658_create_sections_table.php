<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('classes_id')->unsigned();
            $table->integer('session_id')->unsigned();
            $table->string('section_name', 100);
            $table->string('section_short', 100);
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->integer('added_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->softDeletes(); 
        });

        Schema::table('sections', function($table){
            $table->foreign('classes_id')->references('id')->on('classes')->onDelete('cascade');
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
        Schema::dropIfExists('sections');
    }
}
