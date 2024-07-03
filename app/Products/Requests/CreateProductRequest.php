<?php

namespace App\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProductRequest extends FormRequest
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
            'product_info.name'=>'required|min:3',
            'product_info.brand_id'=>'required|numeric|exists:brands,id',
            'product_info.supplier_id'=>'required|numeric|exists:suppliers,id',
            'product_info.category_id'=>'required|numeric|exists:categories,id',
            'product_info.price'=>'required|numeric',
            'product_info.marketer_commission'=>'nullable|numeric',
            'product_info.before_sale_price'=>'nullable|numeric|gt:product_info.price',
            'product_info.cost'=>'required|numeric',
        ];
    }
}
