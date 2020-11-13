<?php


namespace App\Concerns;


trait ProductValidations
{
    /**
     * Validations for create products.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:products,name',
            'slug' => 'required|string',
            'category' => 'required|numeric|exists:categories,id',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required',
            'status' => 'required'
        ];
    }
}
