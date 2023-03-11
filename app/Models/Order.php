<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingAddress;
use App\Models\OrderedProduct;
use App\Models\PaymentInfo;
use App\Models\User;
use App\Models\OrderStatus;

class Order extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(OrderedProduct::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(shippingAddress::class);
    }

    public function paymentInfo()
    {
        return $this->hasOne(PaymentInfo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}
