<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateProvidersTable extends Migration{


    public function up()
    {
        Schema::create('rate_providers', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id');
            $table->string('details')->nullable()->comment('رايك في مقدم الخدمه');
            $table->integer('rate_number');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('rate_providers');
    }
}
