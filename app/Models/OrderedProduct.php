<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderedAttribute;

class OrderedProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "price",
        "quantity",
        "image_url",
        "product_id"
    ];

    public function attributes()
    {
        return $this->hasMany(OrderedAttribute::class, "product_id");
    }
}
