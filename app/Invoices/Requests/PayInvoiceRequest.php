<?php

namespace App\Invoices\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayInvoiceRequest extends FormRequest
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
            'from'=>'required|exists:users,id',
            'value'=>'required|gt:0',
            'note'=>'nullable'
        ];
    }

    public function messages()
    {
        return [
            'from.required'=>'transaction_from_required',
            'value.required'=>'transaction_value_required',
            'value.gt'=>'transaction_value_gt_0',
        ];
    }   
}
