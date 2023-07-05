<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{

    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->double('price')->default(0)->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_ar')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('investments');
    }
}
