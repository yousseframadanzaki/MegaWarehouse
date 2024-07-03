<?php

namespace App\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user_id = $this->route()->parameter('user_id');
        return [
            'name' => 'required',
            'phone_1' => [
                'required',
                'min:11',
                Rule::unique('users','phone_1')->ignore($user_id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore($user_id)
            ],
            'password' => 'nullable|min:6',
            'password2' => 'nullable|required_with:password|same:password|min:6',
            'role_id' => 'required|integer|exists:roles,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
        ];
    }
}
