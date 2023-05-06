<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FormatRequestResponse
{
    public function getInSnakeCase($data)
    {
        $replaced = [];

        foreach ($data as $key => $value) 
        {
            $replaced[Str::snake($key)] = is_array($value) ? $this->getInSnakeCase($value) : $value;
        }

        return $replaced;
    }

    public function getInCamelCase($array)
    {
        $replaced = [];

        foreach ($array as $key => $value) 
        {
            $replaced[Str::camel($key)] = is_array($value) ? $this->getInCamelCase($value) : $value;
        }

        return $replaced;
    }

    public function handle(Request $request, Closure $next)
    {
        $request->replace($this->getInSnakeCase($request->all()));

        $response =  $next($request);

        return $response;

        $response->setContent(json_encode($this->getInCamelCase(json_decode($response->getContent(), true))));

        return $response;
    }
}
