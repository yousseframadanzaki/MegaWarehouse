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

    public function messages()
    {
        return [
            "product_info.name.required" => __("product_info_name_required"),
            "product_info.name.min" => __("product_info_name_min"),
            
            "product_info.brand_id.required" => __("product_info_brand_id_required"),
            "product_info.brand_id.numeric" => __("product_info_brand_id_numeric"),
            "product_info.brand_id.exists" => __("product_info_brand_id_exists"),

            "product_info.supplier_id.required" => __("product_info_supplier_id_required"),
            "product_info.supplier_id.numeric" => __("product_info_supplier_id_numeric"),
            "product_info.supplier_id.exists" => __("product_info_supplier_id_exists"),

            "product_info.category_id.required" => __("product_info_category_id_required"),
            "product_info.category_id.numeric" => __("product_info_category_id_numeric"),
            "product_info.category_id.exists" => __("product_info_category_id_exists"),

            "product_info.price.required" => __("product_info_price_required"),
            "product_info.price.numeric" => __("product_info_price_numeric"),

            "product_info.before_sale_price.numeric" => __("product_info_before_sale_price_numeric"),
            "product_info.before_sale_price.gt" => __("product_info_before_sale_price_gt"),

            "product_info.cost.required" => __("product_info_cost_required"),
            "product_info.cost.numeric" => __("product_info_cost_numeric"),
        ];
    }

}
