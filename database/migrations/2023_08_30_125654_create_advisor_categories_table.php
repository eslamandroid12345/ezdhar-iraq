<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvisorCategoriesTable extends Migration{

    public function up()
    {
        Schema::create('advisor_categories', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('مقدم الخدمه او المستشار')->nullable();
            $table->unsignedBigInteger('sub_category_id')->comment('نوع الخدمه')->nullable();
            $table->unsignedBigInteger('consultant_type_id')->comment('نوع الاستشاره')->nullable();

            $table->string('desc_ar')->comment('	تفاصيل هيقدمها في الخدمة زي مثلا مدة التنفيذ او شروط يجب ارسالها لتقديم الخدمة وتتعرض للعميل اللي هيشتري الخدمه')->nullable();
            $table->string('desc_en')->nullable();
            $table->double('price',12,2)->comment('السعر اللي المستشار او مقدم الخدمة حابب ياخده من العميل');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
            $table->foreign('consultant_type_id')->references('id')->on('consultant_types')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('advisor__categories');
    }
}
