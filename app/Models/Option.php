<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $timestamp = false;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
