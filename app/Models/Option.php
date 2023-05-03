<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;

class Option extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ["name"];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
