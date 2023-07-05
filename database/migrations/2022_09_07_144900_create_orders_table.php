<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration{

    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('advisor_or_user_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('consultation_type_id')->nullable();

            $table->enum('status',['accepted','new','completed','refused'])->comment('مقدم الخدمه او المستشار اللي المفروض يوافق علي الطلب')->default('new');
            $table->string('note')->nullable();
            $table->text('img')->nullable();
            $table->enum('payment_status',['paid','unpaid'])->default('unpaid');
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('advisor_or_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('consultation_type_id')->references('id')->on('consultant_types')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
