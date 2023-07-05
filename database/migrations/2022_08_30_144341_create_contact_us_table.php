<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsTable extends Migration{

    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();

        });
    }


    public function down()
    {
        Schema::dropIfExists('contact_us');
    }
}
