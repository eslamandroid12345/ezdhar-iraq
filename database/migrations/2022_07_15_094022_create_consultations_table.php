<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration{

    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('adviser_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->text('details')->nullable();
            $table->string('payment_status',5)->nullable()->default('0');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('adviser_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
