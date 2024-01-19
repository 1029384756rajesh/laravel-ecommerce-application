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
        $request->validate(["image" => "required|file|mimes:jpeg,jpg,png"]);

        Slider::create(["image" => $request->image->store("images", "public")]);

        return back()->with("success", "Category created successfully");
    }

    public function delete(Slider $slider)
    {
        $slider->delete();

        return back()->with("success", "Category deleted successfully");
    }
}
