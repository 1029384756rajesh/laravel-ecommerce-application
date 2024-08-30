<?php

namespace App\Helpers;

class CategoryHelper
{
    public $categories = [];

    public $labeled = [];

    public $tree = [];

    public function __construct($categories)
    {
        $this->categories = $categories;
        $this->setRoot();
        $this->setChildren($this->tree);
        $this->setLabel($this->tree, 1);
    }

    public function getDirectChildren($parentCategory)
    {
        $children = [];

        foreach ($this->categories as $category) {
            if ($category["parent_id"] == $parentCategory["id"])
                array_push($children, $category);
        }

        return $children;
    }

    public function setChildren(&$givenCategories)
    {
        for ($i = 0; $i < count($givenCategories); $i++) {
            $givenCategories[$i]["children"] = $this->getDirectChildren($givenCategories[$i]);

            $this->setChildren($givenCategories[$i]["children"]);
        }
    }

    public function setRoot()
    {
        foreach ($this->categories as $category) {
            if ($category["parent_id"] == null)
                array_push($this->tree, $category);
        }
    }

    public function getUlFromCategories($categories)
    {
        $ul = "<ul class='category-tree'>";

        foreach ($categories as $category) {
            $ul .= "<li><a href='/products?cid={$category['id']}'>{$category['name']}</a>";

            if (count($category["children"]) > 0) {
                $ul .= $this->getUlFromCategories($category["children"]);
            }

            $ul .= "</li>";
        }

        $ul .= "</ul>";

        return $ul;
    }

    public function setLabel($categories, $label)
    {
        foreach ($categories as $category) {
            array_push($this->labeled, (object) [
                "id" => $category["id"],
                "name" => $category["name"],
                "parent_id" => $category["parent_id"],
                "label" => $label,
            ]);

            $this->setLabel($category["children"], $label + 1);
        }
    }

    public function isChild($parentId, $childId)
    {
        $label = null;

        $exists = false;

        foreach ($this->labeled as $category) {
            if ($parentId == $category->id) {
                $label = $category->label;
                continue;
            }

            if ($label) {
                if ($label >= $category->label)
                    break;

                if ($category->id == $childId)
                    $exists = true;
            }
        }

        return $exists;
    }

    public static function getExpaned($categories, $parentId)
    {
        $result = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] === $parentId) {
                $result[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'children' => $this->getExpaned($categories, $category['id'])
                ];
            }
        }

        return $result;
    }

    public static function getLabeled($categories, $label = 0)
    {
        $result = [];

        foreach (self::getExpaned($categories) as $category) {
            $result[] = [
                'id' => $category['id'],
                'name' => $category['name'],
                'label' => $label
            ];

            if (count($category['children']) > 0) {
                $result = array_merge($result, self::getLabeled($category['children'], $label + 1));
            }
        }

        return $result;
    }

    
}