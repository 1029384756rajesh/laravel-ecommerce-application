<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\CategoryHelper;

class CategoryController extends Controller
{
    public function categories()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        $categories = array_map(fn($category) => [
            "id" => $category["id"],
            "name" => $category["name"],
            "label" => $category["label"],
            "parent_id" => $category["parent_id"]
        ], $categoryHelper->labeled);
        
        return response()->json($categories);
    }

    public function category(Category $category)
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());
        
        return response()->json($category);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->exists())
        {
            return response()->json(["error" => "Category already exists"], 422);
        }

        $category = Category::create($data);

        return response()->json($category);
    }

    public function edit(Request $request, Category $category)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if($category->id == $request->parent_id) return response()->json(["error" => "Category can't be the parent of itself"], 422);

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->whereNot("id", $category->id)->exists())
        {
            return response()->json(["error" => "Category already exists"], 422);
        }

        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        if($categoryHelper->isChild($category->id, $request->parent_id))
        {
            Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);
        }

        $category->update($data);

        return response()->json($category);
    }

    public function delete(Category $category)
    {
        Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);

        $category->delete(); 

        return response()->json($category);
    }
}
