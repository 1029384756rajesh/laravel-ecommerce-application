<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|unique:categories,name',
            'image' => 'required|image'
        ]);

        Category::create([
            'name' => $request->name,
            'image_url' => $request->image->store('images/sliders', 'public'),
        ]);

        return back()->with('success', 'Category created successfully');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:2|max:255|unique:categories,name,' . $category->id,
            'image' => 'nullable|image'
        ]);

        $category->name = $request->name;

        if($request->image)
        {
            $category->image_url = $request->image->store('images/sliders', 'public');
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Category deleted successfully');
    }
}
