<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->unsignedInteger('min_amount')->default(0);
            $table->enum('type', ['percentage', 'amount']);
            $table->unsignedInteger('coupon_limit')->nullable();
            $table->unsignedInteger('user_limit')->nullable();
            $table->unsignedInteger('value');
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_coupons');
    }
};
