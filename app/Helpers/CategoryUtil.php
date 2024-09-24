<?php

namespace App\Helpers;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryUtil
{
    static function flatted(Collection $categories, int|null $parentId = null, string $prefix = "")
    {
        $result = collect();

        $categories->each(function (Category $category) use ($categories, $prefix, $parentId, &$result) {

            if ($category->parent_id === $parentId) {

                $newCategory = collect([
                    'id' => $category->id,
                    'name' => $prefix . $category->name
                ]);

                $result->push($newCategory);

                $result->merge(self::flatted($categories, $category->id, $prefix . "—"));
            }
        });

        return $result;
    }
    
    static function isDecendent($categories, $categoryId, $parentId)
    {
        $categories = self::getFlated($categories, $categoryId);

        foreach ($categories as $category) {
            if ($category['id'] == $parentId) {
                return true;
            }
        }

        return false;
    }

    static function expanded(Collection $categories, int | null $parentId = null)
    {
        $result = collect();

        $categories->each(function(Category $category) use ($categories, $parentId, $result) {

            if ($category->parent_id === $parentId) {

                $category->children = self::expanded($categories, $category->id);

                $result->push($category);
            }
        });

        return $result;
    }

    static function getCategory($categories, $id)
    {
        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                return $category;
            }

            $returnCategory = self::getCategory($category['children'], $id);

            if ($returnCategory) {
                return $returnCategory;
            }
        }

        return null;
    }

    static function isInTree($categories, $id)
    {
        foreach ($categories as $category) {
            if ($category['id'] === $id) {
                return true;
            }

            $isIn = self::isInTree($category['children'], $id);

            if ($isIn) {
                return true;
            }
        }

        return false;
    }
}