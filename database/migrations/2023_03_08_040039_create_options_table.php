<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('options');
    }
};
