<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTitlesTable extends Migration
{

    public function up()
    {
        Schema::create('job_titles', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('job');
            $table->text('image');
            $table->unsignedBigInteger('provider_id');
            $table->timestamps();

            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('job_titles');
    }
}
