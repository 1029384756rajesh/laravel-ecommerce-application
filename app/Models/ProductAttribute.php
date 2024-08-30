<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductAttributeOption;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'type', 'position'];

    public function options()
    {
        return $this->hasMany(ProductAttributeOption::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
