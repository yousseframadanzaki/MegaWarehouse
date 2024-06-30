<?php

namespace App\Roles\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'user_type_id' => 'required',
            'permissions' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'role_name_required',
            'name.min' => 'role_name_min',
            'permissions.required'=>'role_permissions_required'
        ];
    }

}
