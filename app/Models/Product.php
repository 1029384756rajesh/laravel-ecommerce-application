<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductReview;

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
        'category_id'
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
