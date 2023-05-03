<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\CategoryHelper;

class CategoryController extends Controller
{
    public function index()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        $categories = array_map(fn($category) => [
            "id" => $category["id"],
            "name" => $category["name"],
            "label" => $category["label"]
        ], $categoryHelper->labeled);
        
        return response()->json($categories);
    }

    public function create()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        $categories = array_map($categoryHelper->labeled, fn($category) => [
            "id" => $category["id"],
            "name" => $category["name"],
            "label" => $category["label"]
        ]);

        return response()->json(["categories" => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->exists())
        {
            return response()->json(["error" => "Category already exists"]);
        }

        $category = Category::create($data);

        return response()->json($category);
    }

    public function edit(Request $request, Category $category)
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        return view("admin.categories.edit", ["category" => $category, "categories" => $categoryHelper->labeled]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if($category->id == $request->parent_id) 
        {
            return response()->json(["error" => "Category can't be the parent of itself"]);
        }

        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        if($categoryHelper->isChild($category->id, $request->parent_id))
        {
            Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);
        }

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->save();

        return response()->json($category);
    }

    public function delete(Category $category)
    {
        Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);

        $category->delete(); 

        return response()->json($category);
    }
}
