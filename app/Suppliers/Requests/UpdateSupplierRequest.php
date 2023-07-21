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
                'min:3',
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

    public function messages()
    {
        return [
            'name.required' => 'supplier_name_required',
            'name.min' => 'supplier_name_min',
            'address.required' => 'address_required',    
            'address.min' => 'address_min',    
            'phone.required' => 'phone_required',    
            'phone.min' => 'phone_min', 
        ];
    }

}
