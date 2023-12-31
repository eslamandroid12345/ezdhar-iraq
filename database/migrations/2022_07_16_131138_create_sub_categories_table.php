<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoriesTable extends Migration{

    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->string('title_ar')->comment('اسم القسم الفرعي بالعربي')->nullable();
            $table->string('title_en')->nullable();
            $table->string('terms_ar')->comment('الشروط والسياسات بالعربي')->nullable();
            $table->string('terms_en')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
