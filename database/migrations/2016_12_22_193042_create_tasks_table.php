<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('sub_exercise_id');
            $table->unsignedInteger('chained_to')->nullable();
            $table->string('name');
            $table->longText('generator');
            $table->longText('validator');
            $table->enum('status', ['available','testing','disabled','unfinished'])->default('disabled');
            $table->text('options');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('sub_exercise_id')->references('id')->on('sub_exercise_types');
            $table->foreign('chained_to')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
