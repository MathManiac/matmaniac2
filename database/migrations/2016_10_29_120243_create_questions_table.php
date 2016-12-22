<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('result_set_id');
            $table->string('text')->nullable();
            $table->string('value')->nullable();
            $table->unsignedInteger('previous_id')->nullable();
            $table->boolean('skipped')->default(0);
            $table->timestamps();

            $table->foreign('result_set_id')->references('id')->on('result_sets');
            $table->foreign('previous_id')->references('id')->on('questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
