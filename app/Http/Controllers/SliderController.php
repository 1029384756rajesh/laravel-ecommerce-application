<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function sliders()
    {
        return response()->json(Slider::all());
    }
}
