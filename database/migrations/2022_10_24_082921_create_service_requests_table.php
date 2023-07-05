<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{

    public function up()
    {
        Schema::create('service_requests', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('room_id');
            $table->double('price',12,2);
            $table->date('delivery_date')->comment('ميعاد تسليم الطلب');
            $table->text('details')->nullable();
            $table->enum('status',['new', 'accepted', 'refused', 'completed'])->default('new');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('service_requests');
    }
}
