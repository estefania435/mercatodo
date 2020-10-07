<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class RoleStoreRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|max:50|unique:roles,name',
            'slug'        => 'required|max:50|unique:roles,slug',
            'full-access' => 'required|in:yes,no',
        ];
    }
}
