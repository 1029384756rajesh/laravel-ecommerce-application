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
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_variant')->default(false);
            $table->boolean('is_virtual')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->foreignId('tax_class_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
