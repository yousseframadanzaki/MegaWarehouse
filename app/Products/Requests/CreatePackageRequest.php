<?php

namespace App\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePackageRequest extends FormRequest
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
            'product_info.category_id'=>'required|numeric|exists:categories,id',
            'product_info.price'=>'required|numeric',
            'product_info.marketer_commission'=>'nullable|numeric',
            'package' => 'required|array',
            'package.*.variant_id' => 'required',
            'package.*.price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            "product_info.name.required" => __("product_info_name_required"),
            "product_info.name.min" => __("product_info_name_min"),

            "product_info.category_id.required" => __("product_info_category_id_required"),
            "product_info.category_id.numeric" => __("product_info_category_id_numeric"),
            "product_info.category_id.exists" => __("product_info_category_id_exists"),

            "product_info.price.required" => __("product_info_price_required"),
            "product_info.price.numeric" => __("product_info_price_numeric"),

            'package' => __("package_product_required"),
            'package.*.variant_id' => __("package_product_required"),
            'package.*.price' => __("package_product_required"),
        ];
    }

}
