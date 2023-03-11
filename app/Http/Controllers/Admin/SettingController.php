<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.settings.index', [
            'setting' => Setting::first()
        ]);
    }

    public function edit(Request $request)
    {
        return view('admin.settings.edit', [
            'setting' => Setting::first()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'about' => 'required|min:2|max:5000',
            'email' => 'required|email|max:255',
            'mobile' => 'required|min:10|max:10',
            'facebook_url' => 'max:255',
            'instagram_url' => 'max:255',
            'twitter_url' => 'max:255',
            'gst' => 'required|integer',
            'delivery_fee' => 'required|integer',
            'return_address' => 'required|max:255',
        ]);

        $setting = Setting::first();

        $setting->about = $request->about;

        $setting->mobile = $request->mobile;

        $setting->email = $request->email;

        $setting->facebook_url = $request->facebook_url;

        $setting->instagram_url = $request->instagram_url;

        $setting->twitter_url = $request->twitter_url;

        $setting->gst = $request->gst;

        $setting->delivery_fee = $request->delivery_fee;
        
        $setting->return_address = $request->return_address;

        $setting->save();

        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully');
    }
}
