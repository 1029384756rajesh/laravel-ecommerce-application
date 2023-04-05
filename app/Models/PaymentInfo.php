<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'payment_id',
        'product_price',
        'shipping_cost',
        'gst',
        'method',
        'status',
        'gst_amount',
        'total_amount'
    ];
}
