<?php

namespace App\Templates\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTemplateRequest extends FormRequest
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
            'type' =>'required|min:3',
            'text' =>'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'supplier_type_required',
            'type.min' => 'supplier_type_min',
            'text.required' => 'supplier_text_required',
            'text.min' => 'supplier_text_min'
        ];
    }

}
