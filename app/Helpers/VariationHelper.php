<?php 

namespace App\Helpers;

class VariationHelper
{
    private function combineTwoArray($arr1, $arr2)
    {
        $arr3 = [];

        foreach ($arr1 as $arr1Element) 
        {
            foreach ($arr2 as $arr2Element) 
            {
                array_push($arr3, "{$arr1Element}|{$arr2Element}");
            }
        }

        return $arr3;
    }

    private function combineMultipleArrays($arrays)
    {
        for ($i=0; $i < count($arrays) - 1; $i++) 
        { 
            $arrays[$i+1] = $this->combineTwoArray($arrays[$i], $arrays[$i+1]);
        }

        return $arrays[count($arrays)-1];
    }

    private function getOptionArraysFromAttributes($attributes)
    {
        $outerResult = [];

        foreach ($attributes as $attribute) 
        {
            $result = [];

            foreach ($attribute['options'] as $option) 
            {
                array_push($result, $option['id']);
            }

            array_push($outerResult, $result);
        }

        return $outerResult;
    }

    private function convertStrToIntArray($arr)
    {
        $result = [];

        foreach ($arr as $element) 
        {
            array_push($result, explode("|", $element));
        }

        return $result;
    }

    public function getVariationIds($attributes)
    {
        return $this->convertStrToIntArray(
            $this->combineMultipleArrays(
                $this->getOptionArraysFromAttributes($attributes)
            )
        );
    }
}