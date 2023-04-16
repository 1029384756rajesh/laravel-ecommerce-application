<?php 

namespace App\Helpers;

class CategoryHelper 
{
    public $categories = [];

    public function findChildren($parentCategory, $categories)
    {
        $children = [];

        foreach ($categories as $category) 
        {
            if($category["parent_id"] == $parentCategory["id"])
            {
                array_push($children, $category);
            }
        }

        return $children;
    }

    public function setChildren(&$givenCategories)
    {
        for ($i=0; $i < count($givenCategories); $i++) 
        { 
            $givenCategories[$i]["children"] = $this->findChildren($givenCategories[$i], $this->categories);

            $this->setChildren($givenCategories[$i]["children"]);
        }

        return $givenCategories;
    }

    public function getParents($categories)
    {
        $finalResult = [];

        foreach ($categories as $category) 
        {
            if($category["parent_id"] == null)
            {
                array_push($finalResult, $category);
            }
        }
        
        return $finalResult;
    }

    public function getUlFromCategories($categories)
    {
        $ul = "<ul class='category-tree'>";

        foreach ($categories as $category) 
        {
            $ul .= "<li><a href='/products?cid={$category['id']}'>{$category['name']}</a>";
            
            if(count($category["children"]) > 0) 
            {
                $ul .= $this->getUlFromCategories($category["children"]);
            } 
            
            $ul .= "</li>";
        }

        $ul .= "</ul>";

        return $ul;
    }

    public $final = [];

    public function getLabel($categories, $label)
    {    
        foreach ($categories as $category) 
        {
            array_push($this->final, [
                "id" => $category["id"],
                "name" => $category["name"],
                "parent_id" => $category["parent_id"],
                "created_at" => $category["created_at"],
                "updated_at" => $category["updated_at"],
                "label" => $label,
            ]);
    
            if(count($category["children"]) > 0)
            {
                $c = $label + 1;
                $this->getLabel($category["children"], $c);
            }
        }
    }
    
}