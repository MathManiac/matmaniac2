<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubExerciseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_exercise_types', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exercise_type_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('exercise_type_id')->references('id')->on('exercise_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_exercise_types');
    }
}
