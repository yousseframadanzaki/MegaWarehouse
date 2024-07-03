<?php

namespace App\ShippingCompanies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingCompanyRequest extends FormRequest
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
            'username' => 'required|min:3',
            'password' => 'required|min:3',
            'password2' => 'nullable|required_with:password|same:password|min:3',
            'url' => 'required|min:8',
        ];
    }
}
