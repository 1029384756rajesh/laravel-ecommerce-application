<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('attribute', 50);
            $table->string('value', 50);
            $table->foreignId('order_product_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ordered_attributes');
    }
};
