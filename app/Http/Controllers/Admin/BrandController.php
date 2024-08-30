<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::get();
    } 

    public function show(Brand $brand)
    {
        return $brand;
    }   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:brands,name'
        ]);

        return Brand::create($validated);
    }   

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:30|unique:brands,name,' . $brand->id
        ]);

        $brand->update($validated);

        return $brand;
    }   

    public function delete(Brand $brand)
    {
        $brand->delete();
        
        return $brand;
    }   
}
