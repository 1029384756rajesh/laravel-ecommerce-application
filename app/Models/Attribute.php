<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Option;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['stock', 'price', 'gallery'];

    protected $timestamp = false;

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
