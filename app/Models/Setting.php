<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'about',
        'mobile',
        'email',
        'facebook_url',
        'instagra_url',
        'twitter_url',
        'gst',
        'delivery_fee',
        'return_address'
    ];
}
