<?php

namespace App\Products\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVariantRequest extends FormRequest
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
            'sku'=>'required|unique:variants,sku,' . $this->variant_id,
        ];
    }

    public function messages()
    {
        return [
            'sku.unique'=>'حقل ال sku موجود بالفعل'
        ];
    }
}
