<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderReportsTable extends Migration
{

    public function up()
    {
        Schema::create('order_reports', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('order_id');
            $table->string('reason')->comment('سبب المشكله');
            $table->text('details')->nullable()->comment('تفاصيل المشكله');
            $table->text('img')->comment('سجل مرفق او صوره للمحادثه ما بينهم')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');


        });
    }


    public function down(){


        Schema::dropIfExists('order_reports');
    }
}
