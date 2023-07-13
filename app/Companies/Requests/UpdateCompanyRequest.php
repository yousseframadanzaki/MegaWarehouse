<?php

namespace App\Companies\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required|min:6',
            'company_type' => 'required',
            'max_users' => 'required|Integer',
            'max_orders' => 'required|Integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'company_name_required',
            'name.min' =>'company_name_min',
            'company_type.required' =>'company_type_required',
            'max_users.required' =>'max_users_required',
            'max_users.integer' =>'max_users_Integer',
            'max_orders.required' =>'max_orders_required',
            'max_orders.integer' =>'max_orders_Integer',
        ];
    }
}
