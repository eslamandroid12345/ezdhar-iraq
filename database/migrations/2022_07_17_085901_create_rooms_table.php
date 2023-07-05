<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration{



    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('adviser_or_freelancer_id')->nullable();
            $table->unsignedBigInteger('consultation_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->double('is_end')->default(true)->comment('انهاء غرفه المحادثه');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('adviser_or_freelancer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('consultation_id')->references('id')->on('consultant_types')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
