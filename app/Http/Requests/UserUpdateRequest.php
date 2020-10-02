<?php

namespace App\Http\Requests;

use App\MercatodoModels\User;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductStoreRequest
 * @package App\Http\Requests
 */
class UserUpdateRequest extends FormRequest
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
    public function rules(User $user): array
    {
        return [
            'name'           => 'required|max:50|unique:users,name,'.$user->id,
            'surname'        => 'required|max:50,'.$user->id,
            'identification' => 'required|max:50|unique:users,identification,'.$user->id,
            'address'        => 'required|max:50,'.$user->id,
            'phone'          => 'required|max:50,'.$user->id,
            'email'          => 'required|max:50|unique:users,email,'.$user->id,
        ];
    }
}
