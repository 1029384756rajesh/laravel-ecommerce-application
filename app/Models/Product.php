<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProductReview;
use App\Models\Variant;
use App\Models\Sku;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'stock',
        'price',
        'image_url',
        'is_featured',
        'is_active',
        'category_id',
        'gallery'
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }
}
