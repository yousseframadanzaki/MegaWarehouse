<?php

namespace App\Accounting\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTransactionRequest extends FormRequest
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
            'value' => 'required|numeric|min:0',
            'payment_category' => 'required',
            'payment_type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => 'value_required_min',
            'value.min' => 'value_required_min',
            'payment_category.required' => 'payment_category_required',
            'payment_type_id.required' => 'payment_type_id_required',
        ];
    }

}
