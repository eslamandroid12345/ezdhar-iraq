<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration{

    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {


            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('title_en')->nullable();
            $table->double("ownership_rate")->nullable();
            $table->double("success_rate")->nullable()->default(null);
            $table->text('text_ar')->nullable();
            $table->text('text_en')->nullable();
            $table->string('image')->nullable();
            $table->double('cost',12,2);
            $table->enum('status',[0,1]);
            $table->enum('is_investment',[0,1]);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
