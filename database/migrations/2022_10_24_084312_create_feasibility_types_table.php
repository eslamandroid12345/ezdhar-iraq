<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeasibilityTypesTable extends Migration
{

    public function up()
    {
        Schema::create('feasibility_types', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->string('type');
            $table->text('img');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('feasibility_types');
    }
}
