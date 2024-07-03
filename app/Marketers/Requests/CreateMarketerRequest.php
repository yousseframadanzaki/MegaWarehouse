<?php

namespace App\Marketers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMarketerRequest extends FormRequest
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
            'name'=>'required|min:3',
            'page_name'=>'required|min:3',
            'phone_number'=>'required|min:11',
            'links'=>'nullable',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password2' => 'nullable|required_with:password|same:password|min:6',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }
}
