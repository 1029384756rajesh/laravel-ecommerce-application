<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariation;

class ProductVariationImage extends Model
{
    use HasFactory;

    protected $fillable = ['src', 'position'];

    public $timestamps = false;

    public function variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }
}
