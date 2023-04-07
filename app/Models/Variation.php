<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Option;
use App\Models\VariationOption;

class Variation extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variationOptions()
    {
        return $this->hasMany(VariationOption::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, "variation_options");
    }
}
