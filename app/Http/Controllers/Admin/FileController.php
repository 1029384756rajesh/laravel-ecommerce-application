<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function files()
    {
        $result = [];

 

        foreach (Storage::disk("public")->files("images") as $file) 
        {
            array_push($result, [
      
                "name" => str_replace("images/", "", $file),
                "url" => env("APP_URL") . "/uploads/" . $file
            ]);
        }
        return response()->json($result);
    }

    public function create(Request $request)
    {
        foreach ($request->file("files") as $file) 
        {
            Storage::disk("public")->put("images/{$file->getClientOriginalName()}", file_get_contents($file));
        }

        return response()->json(["success" => "File uploaded successfully"]);
    }
}
