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

    public function messages()
    {
        return [
            'company.name.required' =>'company_name_required',
            'company.name.min' =>'company_name_min',
            'company.company_type.required' =>'company_type_required',
            'company.max_users.required' =>'max_users_required',
            'company.max_users.integer' =>'max_users_Integer',
            'company.max_orders.required' =>'max_orders_required',
            'company.max_orders.integer' =>'max_orders_Integer',
            'warehouse.name.required' =>'warehouse_name_required',
            'warehouse.name.min' =>'warehouse_name_min',
            'user.name.required' => 'user_name_required',
            'user.name.min' => 'user_name_min',
            'user.phone_1.required' => 'user_phone_1_required',
            'user.phone_1.min' => 'user_phone_1_min',
            'user.phone_1.unique' => 'user_phone_1_unique',
            'user.email.required' => 'user_email_required',
            'user.email.email' => 'user_email_email',
            'user.email.unique' => 'user_email_unique',
            'user.password.required' => 'password_required',
            'user.password.min' => 'password_min',
        ];
    }


}
