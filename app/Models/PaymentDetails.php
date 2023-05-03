<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "product_price",
        "shipping_cost",
        "gst",
        "gst_amount",
        "total_amount"
    ];
}
