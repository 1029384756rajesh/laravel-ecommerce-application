<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ProductVariationImage;
use App\Models\ProductAttributeOption;

class ProductVariation extends Model
{
    use HasFactory;
        
    protected $fillable = [
        'barcode',
        'sku',

        'regular_price',
        'sale_price',
        'sale_start_at',
        'sale_end_at',

        'manage_stock',
        'stock_quantity',
        'allow_barcode',
        'stock_threshold',
        'stock_status',

        'length',
        'width',
        'height',
        'weight',
        
        'download_link',
        'link_expires_at',
        'download_limit'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function options()
    {
        return $this->belongsToMany(ProductAttributeOption::class, 'product_variation_options');
    }
}
