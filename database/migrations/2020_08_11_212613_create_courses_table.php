<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->integer('cupos')->nullable();
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->longText('schedule')->nullable();
            $table->integer('length')->nullable();
            $table->string('date_ini')->nullable();
            $table->integer('length_unit_id')->unsigned()->nullable();
            $table->string('effort')->nullable();
            $table->integer('level_id')->unsigned()->nullable();
            $table->integer('user_instructor_id')->unsigned();
            $table->string('certificate')->nullable();
            $table->string('discount_uno')->nullable();
            $table->string('discount_dos')->nullable();
            $table->string('discount_tres')->nullable();
            $table->string('title_certificate')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('price')->nullable();
            $table->integer('status_id')->unsigned();
            $table->integer('currency_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('length_unit_id')->references('id')->on('length_units');
            $table->foreign('level_id')->references('id')->on('levels');
            $table->foreign('user_instructor_id')->references('id')->on('users');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
