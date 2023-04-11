<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view("admin.categories.index", ["categories" => Category::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:2|max:255|unique:categories,name"
        ]);

        $category = Category::create(["name" => $request->name]);

        return back()->with("success", "Category created successfully");
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required|min:2|max:255|unique:categories,name," . $category->id,
        ]);

        $category->name = $request->name;

        $category->save();

        return back()->with("success", "Category created successfully");
    }

    public function edit(Request $request, Category $category)
    {
        return view("admin.categories.edit", ["category" => $category]);
    }

    public function delete(Category $category)
    {
        $category->delete();

        return back()->with("success", "Category deleted successfully");
    }
}
