<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLengthUnitsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('length_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('value')->nullable();
            $table->integer('length_unit_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('length_unit_id')->references('id')->on('length_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('length_units');
    }
}
