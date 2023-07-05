<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('project_reviews', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->double('rate',12,2)->default(0);
            $table->string('report')->nullable();

            $table->timestamps();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->comment("المستشار اللي هيدي تقييم للمشروع");
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_reviews');
    }
}
