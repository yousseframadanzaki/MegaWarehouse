<?php

namespace App\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreateUserRequest extends FormRequest
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
            'name' => 'required',
            'phone_1' => 'required|min:11|unique:users,phone_1',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password2' => 'nullable|required_with:password|same:password|min:6',
            'role_id' => 'required|integer|exists:roles,id',
            'warehouse_id' => 'required|integer|exists:warehouses,id',
            'image'=>'file|max:10240|mimes:jpg,bmp,png'
        ];
    }
}
