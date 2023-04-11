<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        return view("admin.sliders.index", ["sliders" => Slider::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "image_url" => "required"
        ]);

        $slider = Slider::create([
            "image_url" => $request->image_url,
        ]);

        return back()->with("success", "Slider created successfully");
    }

    public function delete(Slider $slider)
    {
        $slider->delete();

        return back()->with("success", "Slider deleted successfully");
    }
}
