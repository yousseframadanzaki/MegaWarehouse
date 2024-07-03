<?php

namespace App\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
            'company.name' => 'required|min:6',
            'company.company_type' => 'required',
            'company.max_users' => 'required|Integer',
            'company.max_orders' => 'required|Integer',
            'company.code' => 'required|min:3',
            'warehouse.name' => 'required|min:3',
            'user.name' => 'required|min:6',
            'user.phone_1' => 'required|min:11|unique:users,phone_1',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|min:6',
        ];
    }


}
