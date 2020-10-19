<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->float('total');
            $table->string('talon_cobro')->nullable();
            $table->string('url_pdf')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->string('payment_metod_mp')->nullable();
            $table->string('order_id_mp')->nullable();
            $table->string('order_status_mp')->nullable();
            $table->string('cancelled_mp')->nullable();
            $table->string('status_mp')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
