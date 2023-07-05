<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id')->comment('not null if user freelancer')->nullable();
            $table->unsignedBigInteger('consultant_type_id')->comment('not null if user adviser')->nullable();
            $table->double('consultant_price')->default(0)->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('phone_code')->nullable();
            $table->enum('user_type',['client','freelancer','adviser'])->nullable();
            $table->string('email')->nullable();
            $table->date('birthdate')->nullable();
            $table->double('years_ex')->default(0)->nullable();
            $table->text('bio')->nullable();
            $table->string('graduation_rate')->nullable();
            $table->double('wallet',12,2)->default(0)->comment('محفظه المستخدم');
            $table->boolean('status')->default(true)->comment('حاله المستخدم');
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('consultant_type_id')->references('id')->on('consultant_types')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
