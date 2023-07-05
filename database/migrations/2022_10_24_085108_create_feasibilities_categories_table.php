<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeasibilitiesCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('feasibilities_categories', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('feasibility_id');
            $table->double('price',12,2);
            $table->text('details')->nullable();
            $table->timestamps();

            $table->foreign('feasibility_id')->references('id')->on('feasibilities')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('feasibilities_categories');
    }
}
