<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProductAttribute;
use App\Models\Order;

class OrderProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'product_id'
    ];

    public function attributes()
    {
        return $this->hasMany(OrderProductAttribute::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
