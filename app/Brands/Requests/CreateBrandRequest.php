<?php

namespace App\Brands\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrandRequest extends FormRequest
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
            'name'=>'required|min:3',
            'logo'=>'nullable|file|max:1024|mimes:jpg,bmp,png'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'brand_name_required',
            'name.min' => 'brand_name_min',
            'logo.required' => 'brand_logo_required',
            'logo.max' => 'brand_logo_max',
            'logo.mimes' => 'brand_logo_mimes',
        ];
    }
}
