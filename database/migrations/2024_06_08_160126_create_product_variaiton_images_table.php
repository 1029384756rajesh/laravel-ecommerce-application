<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variation_images', function (Blueprint $table) {
            $table->id();
            $table->string('src');
            $table->integer('position');
            $table->foreignId('product_variation_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variation_images');
    }
};
