<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function settings()
    {
        return response()->json(Setting::first());
    }
}
