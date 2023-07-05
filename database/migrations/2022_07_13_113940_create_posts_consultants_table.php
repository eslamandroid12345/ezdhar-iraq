<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsConsultantsTable extends Migration
{

    public function up()
    {
        Schema::create('posts_consultants', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('post_id')->nullable();
            $table->unsignedBigInteger('consultant_type_id')->nullable();
            $table->enum('status',['new','approved','rejected'])->default('new');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('consultant_type_id')->references('id')->on('consultant_types')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('posts_consultants');
    }
}
