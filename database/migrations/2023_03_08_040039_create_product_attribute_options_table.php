<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_attribute_options', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('value')->nullable();
            $table->integer('position');
            $table->foreignId('product_attribute_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_attribute_options');
    }
};
