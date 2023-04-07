<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Variation;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    
    protected $fillable = [
        'product_id',
        'variation_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
