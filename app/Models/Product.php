<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\ProductImage;

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
        return $this->belongsToMany(User::class, 'product_reviews')->withPivot('review')->withTimeStamps();
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
