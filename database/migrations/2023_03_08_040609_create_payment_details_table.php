<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->integer('method');
            $table->integer('product_price');
            $table->integer('shipping_cost');
            $table->integer('gst');
            $table->integer('gst_amount');
            $table->integer('total_amount');
            $table->string('status');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
};
