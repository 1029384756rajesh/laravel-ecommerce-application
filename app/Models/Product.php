<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\Option;
use App\Models\Attribute;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "name",
        "short_description",
        "description",
        "has_variations",
        "is_completed",
        "category_id",
        "images",
        "price",
        "stock",
        "min_price",
        "max_price"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function variations()
    {
        return $this->hasMany(Product::class, "parent_id");
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, "variation_options");
    }

    public function parent()
    {
        return $this->belongsTo(Product::class, "parent_id");
    }
}
