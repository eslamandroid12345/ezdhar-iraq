<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{

    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('city_name_ar')->nullable();
            $table->string('city_name_en')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
