<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingLocation;
use App\Models\ShippingMethod;

class ShippingZone extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function locations()
    {
        return $this->hasMany(ShippingLocation::class);
    }

    public function methods()
    {
        return $this->hasMany(ShippingMethod::class);
    }
}
