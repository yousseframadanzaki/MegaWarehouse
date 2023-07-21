<?php

namespace App\Warehouses\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
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
        $warehouse_id = $this->route()->parameter('warehouse_id');
        return [
            'name'=>[
                'required',
                'min:3',
                Rule::unique('warehouses', 'name')
                ->where('company_id', auth()->user()->company_id)
                ->ignore($warehouse_id,'id')
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
