<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_price',
        'shipping_cost',
        'gst',
        'method',
        'status',
        'gst_amount',
        'total_amount'
    ];
}
