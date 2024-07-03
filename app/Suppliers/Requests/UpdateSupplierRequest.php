<?php

namespace App\Suppliers\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $supplier_id = $this->route()->parameter('supplier_id');
        return [
            'name'=>[
                'required',
                Rule::unique('suppliers', 'name')
                ->where('company_id', auth()->user()->company_id)
                ->ignore($supplier_id,'id')
            ],
            'address' => 'required|min:10',
            'phone' => 'required|min:11',
            'payment_methods' => 'nullable',
            'contacts' => 'nullable',
        ];
    }
}
