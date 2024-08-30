<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttribute;

class ProductAttributeOption extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'name', 'value', 'position', 'is_default'];

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'product_attribute_id', 'id');
    }
}
