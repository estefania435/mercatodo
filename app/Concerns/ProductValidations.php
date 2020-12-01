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
            'name' => 'required|string',
            'slug' => 'required|string',
            'category' => 'required|exists:categories,name',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required',
            'status' => 'required'
        ];
    }
}
