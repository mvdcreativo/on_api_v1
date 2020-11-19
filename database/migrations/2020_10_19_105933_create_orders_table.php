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
            $table->unsignedInteger('user_id');
            $table->float('total');
            $table->string('talon_cobro')->nullable();
            $table->bigInteger('payment_method_id')->nullable();
            $table->unsignedInteger('status_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->string('payment_metod_mp')->nullable();
            $table->string('order_id_mp')->nullable();
            $table->string('order_status_mp')->nullable();
            $table->string('cancelled_mp')->nullable();
            $table->string('status_mp')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_one')->nullable();
            $table->string('address_one')->nullable();
            $table->string('n_doc_iden')->nullable();
            $table->string('type_doc_iden')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
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
