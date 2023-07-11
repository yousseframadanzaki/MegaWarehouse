<?php

namespace App\Authentication\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'identity' => 'required|min:6',
            'password' => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'identity.required' => 'identity_required',
            'identity.min' => 'identity_min',
            'password.required' => 'password_required',
            'password.min' => 'password_min',
        ];
    }


}
