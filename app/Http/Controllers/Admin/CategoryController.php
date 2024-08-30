<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\CategoryUtil;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::all();

        return CategoryUtil::getFlated($categories);
    }

    public function category(Category $category)
    {        
        return $category;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->exists())
        {
            return response()->json(["success" => false, 'message' => "Category already exists"], 409);
        }

        Category::create($data);

        return response()->json(['success' => true, 'message' => 'Category created successfully'], 201);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if($category->id == $request->parent_id) 
        {
            return response()->json(['success' => false, "message" => "Category can't be the parent of itself"], 400);
        }

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->whereNot("id", $category->id)->exists())
        {
            return response()->json(['success' => false, "message" => "Category already exists"], 409);
        }

        if(CategoryUtil::isDecendent(Category::get(), $category->id, $request->parent_id))
        {
            Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);
        }

        $category->update($validated);

        return response()->json(["success" => false, 'message' => "Category updated successfully"]);
    }

    public function delete(Category $category)
    {
        Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);

        $category->delete(); 

        return response()->json(["success" => true, 'message' => "Category deleted successfully"]);
    }
}
