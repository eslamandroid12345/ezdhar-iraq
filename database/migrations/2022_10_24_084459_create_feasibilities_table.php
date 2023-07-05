<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeasibilitiesTable extends Migration
{

    public function up()
    {
        Schema::create('feasibilities', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('feasibility_type_id');
            $table->text('img')->nullable();
            $table->string('project_name');
            $table->integer('ownership_rate');
            $table->string('note')->nullable();
            $table->text('details')->nullable();
            $table->double('total',12,2);
            $table->boolean('show')->default(false)->comment('اذا كنت تريد عرض مشروعك في الاستثمار');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('feasibility_type_id')->references('id')->on('feasibility_types')->onDelete('cascade');

        });
    }


    public function down()
    {
        Schema::dropIfExists('feasibilities');
    }
}
