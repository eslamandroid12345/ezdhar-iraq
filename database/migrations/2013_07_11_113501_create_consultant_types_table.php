<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultantTypesTable extends Migration
{

    public function up()
    {
        Schema::create('consultant_types', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('consultant_types');
    }
}
