<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();

            $table->integer('regular_price');
            $table->integer('sale_price')->nullable();
            $table->dateTime('sale_start_at')->nullable();
            $table->dateTime('sale_end_at')->nullable();

            $table->boolean('manage_stock')->default(false);
            $table->unsignedInteger('stock_quantity')->nullable();
            $table->boolean('allow_backorder')->nullable()->default(false);
            $table->unsignedInteger('stock_threshold')->nullable();
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'backordered']);

            $table->unsignedInteger('length')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('weight')->nullable();

            $table->string('download_link')->nullable();
            $table->dateTime('link_expires_at')->nullable();
            $table->unsignedInteger('download_limit')->nullable();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('variations');
    }
};
