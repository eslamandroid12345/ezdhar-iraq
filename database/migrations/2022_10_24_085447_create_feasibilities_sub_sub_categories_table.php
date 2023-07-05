<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeasibilitiesSubSubCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('feasibilities_sub_sub_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('feasibility_sub_category_id');
            $table->double('price',12,2);
            $table->text('details')->nullable();
            $table->timestamps();

            $table->foreign('feasibility_sub_category_id')->references('id')->on('feasibilities_sub_categories')->onDelete('cascade');


        });
    }


    public function down()
    {
        Schema::dropIfExists('feasibilities_sub_sub_categories');
    }
}
