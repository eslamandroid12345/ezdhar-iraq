<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{

    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->enum('type',['voice','text','file'])->default('text');
            $table->text('text')->nullable();

            $table->timestamps();
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
