<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function sliders()
    {
        return response()->json(Slider::all());
    }

    public function create(Request $request)
    {
        $request->validate([
            "image" => "required"
        ]);

        $slider = Slider::create([
            "image" => $request->image,
        ]);

        return response()->json($slider);
    }

    public function delete(Slider $slider)
    {
        $slider->delete();

        return response()->json($slider);
    }
}
