<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;

class OrderProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['attribute', 'value'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(OrderProduct::class);
    }
}
