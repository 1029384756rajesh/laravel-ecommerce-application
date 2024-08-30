<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('mobile', 50);
            $table->string('pincode', 50);
            $table->string('location', 50);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('country', 50);
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
