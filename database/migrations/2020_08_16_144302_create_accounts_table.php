<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('bio')->nullable();
            $table->string('certificated')->nullable();
            $table->integer('rating_up')->nullable();
            $table->integer('rating_down')->nullable();
            $table->string('n_identification')->nullable();
            $table->string('phone_one')->nullable();
            $table->integer('phone_two')->nullable();
            $table->string('address_one')->nullable();
            $table->string('address_two')->nullable();
            $table->string('image')->nullable();
            $table->integer('role_id')->unsigned();
            $table->date('birth')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accounts');
    }
}
