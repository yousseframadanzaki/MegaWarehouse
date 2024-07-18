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
            'warehouse_to_id'=>'exclude_unless:type,move|required|different:warehouse_id',
            'supplier_id' => 'exclude_unless:type,buy|required'
            // 'invoice_number' =>'required|unique:invoices,invoice_number',
        ];
    }
}
