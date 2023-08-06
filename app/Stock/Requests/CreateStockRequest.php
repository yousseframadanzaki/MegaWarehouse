<?php

namespace App\Stock\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStockRequest extends FormRequest
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
            'warehouse_id' => 'required|exists:warehouses,id',
            'type' => 'required|in:buy,sell,move',    
            'product_variants' => 'required|array|min:1',
            'product_variants.id' => 'exists:variants,id',
            'warehouse_to_id'=>'required_if:type,move|different:warehouse_id'
        ];
    }

    public function messages()
    {
        return [
            'warehouse_id.required' => 'warehouse_id_required',
            'warehouse_id.exists' => 'warehouse_id_exists',
            'type.required' => 'type_required',
            'product_variants.required' => 'product_variants_required',
            'warehouse_to_id.required_if' => 'warehouse_to_id_required_if',
            'warehouse_to_id.different' => 'warehouse_to_id_different',
        ];
    }

}
