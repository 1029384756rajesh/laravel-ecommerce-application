<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'image_url',
        'quantity'
    ];
}
