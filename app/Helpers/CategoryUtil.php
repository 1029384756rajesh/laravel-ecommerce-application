<?php

namespace App\Helpers;

class CategoryUtil
{
    static function getFlated($categories, $parentId = null, $prefix = "") 
    {
        $result = [];

        foreach ($categories as $category) 
        {
            if ($category->parent_id === $parentId) 
            {
                array_push($result, [
                    'id' => $category->id,
                    'name' => $prefix . $category->name
                ]);

                $result = array_merge($result, self::getFlated($categories, $category->id, $prefix . "—"));
            }
        }

        return $result;
    }
    static function isDecendent($categories, $categoryId, $parentId) 
    {
        $categories = self::getFlated($categories, $categoryId);

        foreach($categories as $category)
        {
            if($category['id'] == $parentId)
            {
                return true;
            }
        }

        return false;
    }

    static function expanded($categories, $parentId = null)
    {
        $result = collect();

        foreach ($categories as $category) 
        {
            if ($category->parent_id === $parentId) 
            {
                $category->children = self::expanded($categories, $category->id);

                $result->push($category);
            }
        }

        return $result;
    }

    static function getCategory($categories, $id)
    {
        foreach ($categories as $category) 
        {
            if ($category['id'] === $id) 
            {
                return $category;
            }

            $returnCategory = self::getCategory($category['children'], $id);

            if ($returnCategory) 
            {
                return $returnCategory;
            }
        }

        return null;
    }

    static function isInTree($categories, $id)
    {
        foreach ($categories as $category) 
        {
            if ($category['id'] === $id) 
            {
                return true;
            }

            $isIn = self::isInTree($category['children'], $id);

            if ($isIn) 
            {
                return true;
            }
        }

        return false;
    }
}