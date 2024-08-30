<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_zone_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('countries_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('state_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('city', 50)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->foreignId('shipping_zone_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_zone_locations');
    }
};
