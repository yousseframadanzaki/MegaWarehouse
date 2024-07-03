<?php

namespace App\Brands\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
        $brand_id = $this->route()->parameter('brand_id');
        return [
            'name'=>[
                'required',
                'min:3',
                Rule::unique('brands', 'name')
                ->where('company_id', auth()->user()->company_id)
                ->ignore($brand_id,'id')
            ],
            'logo'=>'nullable|file|max:1024|mimes:jpg,bmp,png'
        ];
    }
}
