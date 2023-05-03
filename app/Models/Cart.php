<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Variation;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    
    protected $fillable = [
        "variation_id",
        "quantity"
    ];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
