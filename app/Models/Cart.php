<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    
    protected $fillable = ['name', 'price', 'image_url', 'quantity', 'product_id'];
    
    use HasFactory;
}
