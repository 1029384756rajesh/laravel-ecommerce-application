<?php 

namespace App\Helpers;

class LangHelper 
{
    public static function arrayFind($array, $callback)
    {
        foreach ($array as $elment) if($callback($elment)) return $elment;
        
        return false;
    }
}