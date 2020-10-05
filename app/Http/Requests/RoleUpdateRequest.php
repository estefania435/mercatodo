<?php

namespace App\Http\Requests;

use App\MercatodoModels\Role;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductStoreRequest
 * @package App\Http\Requests
 */
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
     * @return array
     */
    public function rules(Role $role): array
    {
        return [
            'name'        => 'required|max:50|unique:roles,name,' . $role->id,
            'slug'        => 'required|max:50|unique:roles,slug,' . $role->id,
            'full-access' => 'required|in:yes,no',
        ];
    }
}
