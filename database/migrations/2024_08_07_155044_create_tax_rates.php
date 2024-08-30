<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('city', 50)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('name', 50);
            $table->unsignedInteger('rate');
            $table->foreignId('tax_class_id')->constrained('tax_classes')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_rates');
    }
};
