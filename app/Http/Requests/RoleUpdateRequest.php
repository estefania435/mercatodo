<?php

namespace App\Http\Requests;

use App\MercatodoModels\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
     * @param Role $role
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|max:50',
            'slug'        => 'required|max:50',
            'full-access' => 'required|in:yes,no'
        ];
    }
}
