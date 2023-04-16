<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $ch = new \App\Helpers\CategoryHelper();

        $categories = \App\Models\Category::all()->toArray();
   
        $parentCategory = $ch->getParents($categories);
   
        $ch->categories = $categories;
   
        $ch->setChildren($parentCategory);
   
   
       $ch->getLabel($parentCategory, 1);

        return view("admin.categories.index", ["categories" => $ch->final]);
    }

    public function create()
    {
        $ch = new \App\Helpers\CategoryHelper();

        $categories = \App\Models\Category::all()->toArray();
   
        $parentCategory = $ch->getParents($categories);
   
        $ch->categories = $categories;
   
        $ch->setChildren($parentCategory);
   
   
        $ch->getLabel($parentCategory, 1);

       return view("admin.categories.create", ["categories" => $ch->final]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:2|max:255",
            "parent_id" => "nullable|exists:categories,id",
        ]);

        $category = Category::create(["name" => $request->name]);
        if($request->parent_id)
        {
            $category->parent_id = $request->parent_id;
            $category->save();
        }

        return back()->with("success", "Category created successfully");
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required|min:2|max:255",
        ]);

        $category->name = $request->name;
        $category->parent_id = $request->parent_id;

        $category->save();

        return back()->with("success", "Category created successfully");
    }

    public function edit(Request $request, Category $category)
    {
        $ch = new \App\Helpers\CategoryHelper();

        $categories = \App\Models\Category::all()->toArray();
   
        $parentCategory = $ch->getParents($categories);
   
        $ch->categories = $categories;
   
        $ch->setChildren($parentCategory);
   
   
       $ch->getLabel($parentCategory, 1);


        return view("admin.categories.edit", ["category" => $category, "categories" => $ch->final]);
    }

    public function delete(Category $category)
    {
        $category->delete();

        return back()->with("success", "Category deleted successfully");
    }
}
