<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{

    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->string('about_ar')->nullable();
            $table->string('about_en')->nullable();
            $table->string('terms_ar')->nullable();
            $table->string('terms_en')->nullable();
            $table->string('privacy_ar')->nullable();
            $table->string('privacy_en')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
