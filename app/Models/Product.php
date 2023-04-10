<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Image;
use App\Models\Variation;
use App\Models\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'has_variations',
        'short_description',
        'description',
        'stock',
        'price',
        'image_url',
        'is_featured',
        'category_id',
        'is_published'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }
}
