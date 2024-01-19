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
        
        return view("admin.categories.index", ["categories" => $categoryHelper->labeled]);
    }

    public function category(Category $category)
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());
        
        return response()->json($category);
    }

    public function create()
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());
        
        return view("admin.categories.create", ["categories" => $categoryHelper->labeled]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->exists())
        {
            return back()->withErrors(["name" => "Category already exists"])->withInput($request->all());
        }

        Category::create($data);

        return back()->with("success", "Category created successfully");
    }

    public function edit(Category $category)
    {
        $categoryHelper = new CategoryHelper(Category::all()->toArray());
        
        return view("admin.categories.edit", [
            "categories" => $categoryHelper->labeled,
            "category" => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id"
        ]);

        if($category->id == $request->parent_id) 
        {
            return back()->withErrors(["name" => "Category can't be the parent of itself"])->withInput($request->all());
        }

        if(Category::where("parent_id", $request->parent_id)->where("name", $request->name)->whereNot("id", $category->id)->exists())
        {
            return back()->withErrors(["name" => "Category already exists"])->withInput($request->all());
        }

        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        if($categoryHelper->isChild($category->id, $request->parent_id))
        {
            Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);
        }

        $category->update($data);

        return redirect("/admin/categories")->with("success", "Category updated successfully");
    }

    public function delete(Category $category)
    {
        Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);

        $category->delete(); 

        return back()->with("success", "Category deleted successfully");
    }
}
