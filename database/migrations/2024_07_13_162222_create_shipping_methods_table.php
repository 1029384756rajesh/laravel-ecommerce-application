<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->unsignedInteger('min_days')->nullable();
            $table->unsignedInteger('max_days')->nullable();
            $table->unsignedInteger('amount')->default(0);
            $table->enum('rule', ['weight', 'price'])->nullable();
            $table->unsignedInteger('min_value')->nullable();
            $table->unsignedInteger('max_value')->nullable();
            $table->foreignId('shipping_zone_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
};
