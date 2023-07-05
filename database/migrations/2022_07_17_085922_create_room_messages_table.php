<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomMessagesTable extends Migration
{

    public function up()
    {
        Schema::create('room_messages', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();

            $table->enum('type',['voice','text','file'])->default('text');
            $table->text('message')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_messages');
    }
}
