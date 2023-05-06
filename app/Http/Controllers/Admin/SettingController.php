<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view("admin.settings.index", ["settings" => Setting::first()]);
    }

    public function edit()
    {
        return view("admin.settings.edit", ["settings" => Setting::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            "about" => "required|min:2|max:5000",
            "email" => "required|email|max:255",
            "mobile" => "required|min:10|max:10",
            "gst" => "required|integer",
            "shipping_cost" => "required|integer"
        ]);

        Setting::first()->update($data);

        return redirect("/admin/settings")->with(["success" => "Setting updated sucessfully"]);
    }
}
