<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_featured')->default(true);
            $table->string('image_url');
            $table->string('short_description')->nullable();
            $table->boolean('has_variations')->default(false);
            $table->text('description')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('price')->nullable();
            $table->integer('min_price')->nullable();
            $table->integer('max_price')->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null')->onUpdate('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
