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

        return view("admin.categories.index", ["categories" => $categoryHelper->labeled]);
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
            return back()->withErrors(["parent_id" => "Category can't be the parent of itself"])->withInputs($request->all());
        }

        $categoryHelper = new CategoryHelper(Category::all()->toArray());

        if($categoryHelper->isChild($category->id, $request->parent_id))
        {
            Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);
        }

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;
        $category->save();

        return back()->with("success", "Category updated successfully");
    }

    public function delete(Category $category)
    {
        Category::where("parent_id", $category->id)->update(["parent_id" => $category->parent_id]);

        $category->delete();

        return back()->with("success", "Category deleted successfully");
    }
}
