<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;
use App\Models\Option;
use App\Models\Image;

class Variation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "price",
        "stock",
        "image_id"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, "variation_options");
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
