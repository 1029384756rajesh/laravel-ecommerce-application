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
        'price',
        'short_description',
        'long_description',
        'stock',
        'image_url',
        'is_featured',
        'is_active',
        'category_id',
        'gallery'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
