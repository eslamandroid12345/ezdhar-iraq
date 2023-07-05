<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->string('image')->nullable();
            $table->integer('limit')->comment('عدد الاوردرات المسموح بقبولها تبع هذا القسم');
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
