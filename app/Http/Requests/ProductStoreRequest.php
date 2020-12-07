<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|unique:products,name',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slug' => 'required|string',
            'category_id' => 'required',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'status' => 'required'
        ];
    }
}
