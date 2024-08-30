<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UpdateProductRequest implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return 
    }


    public function message()
    {
        return 'The validation error message.';
    }
}
