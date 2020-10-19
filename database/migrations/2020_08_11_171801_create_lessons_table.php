<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->float('price')->nullable();
            $table->string('video')->nullable();
            $table->string('duration')->nullable();
            $table->integer('position')->nullable();


            $table->integer('currency_id')->unsigned()->nullable();
            $table->integer('course_section_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('course_section_id')->references('id')->on('course_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lessons');
    }
}
