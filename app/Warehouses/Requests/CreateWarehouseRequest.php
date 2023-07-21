<?php

namespace App\Warehouses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateWarehouseRequest extends FormRequest
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
            'name'=>[
                'required',
                'min:3',
                Rule::unique('warehouses', 'name')->where('company_id', auth()->user()->company_id)
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'warehouse_name_required',
            'name.min'=>'warehouse_name_min',
            'name.unique'=>'warehouse_name_unique',
        ];
    }   
}
