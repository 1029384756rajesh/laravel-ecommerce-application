<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function settings(Request $request)
    {
        return response()->json(Setting::first());
    }

    public function edit(Request $request)
    {
        $data = $request->validate([
            "about" => "required|min:2|max:5000",
            "email" => "required|email|max:255",
            "mobile" => "required|min:10|max:10",
            "gst" => "required|integer",
            "shipping_cost" => "required|integer"
        ]);

        Setting::first()->update($data);

        return response()->json(["success" => "Setting updated sucessfully"]);
    }
}
