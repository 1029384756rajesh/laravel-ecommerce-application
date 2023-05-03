<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'cart';
    
    protected $fillable = [
        "product_id",
        "quantity"
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, "cart");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
