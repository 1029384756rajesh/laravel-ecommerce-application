<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
        return [
            'name' => 'required|string|max:100|unique:products,name',
            'short_description' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:5000',
            'category_id' => 'nullable|integer|exists:categories,id',
            'has_variations' => 'required|boolean',

            'length' => 'required_if:has_variations,false|integer',
            'breadth' => 'required_if:has_variations,false|integer',
            'height' => 'required_if:has_variations,false|integer',
            'weight' => 'required_if:has_variations,false|integer',
            'price' => 'required_if:has_variations,false|integer',
            'stock' => 'required_if:has_variations,false|integer',
            'shipping_class_id' => 'nullable|integer',
            'tax_class_id' => 'nullable|integer',
            'images' => 'required_if:has_variations,false|array',
            'images.*' => 'required|array',
            'images.*.src' => 'required|url',
            'images.*.position' => 'required|integer',

            'attributes' => 'required_if_accepted:has_variations|array',
            'attributes.*.name' => 'required|string|max:50',
            'attributes.*.position' => 'required|integer',
            'attributes.*.options' => 'required|array',
            'attributes.*.options.*.name' => 'nullable|string|max:255',
            'attributes.*.options.*.position' => 'nullable|integer',

            'variations' => 'required_if_accepted:has_variations|array',
            'variations.*.length' => 'nullable|integer',
            'variations.*.breadth' => 'nullable|integer',
            'variations.*.height' => 'nullable|integer',
            'variations.*.weight' => 'nullable|integer',
            'variations.*.price' => 'required|integer',
            'variations.*.stock' => 'required|integer',
            'variations.*.shipping_class_id' => 'nullable|integer',
            'variations.*.tax_class_id' => 'nullable|integer',

            'variations.*.attributes' => 'required_if_accepted:has_variations|array',
            'variations.*.attributes.*' => 'required|array',
            'variations.*.attributes.*.name' => 'required|string|max:50',
            'variations.*.attributes.*.option' => 'required|string|max:50',
            
            'variations.*.images' => 'required|array',
            'variations.*.images.*' => 'required|array',
            'variations.*.images.*.src' => 'required|url',
            'variations.*.images.*.position' => 'required|integer',
        ];
    }
}
