<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'rating', 'review'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
