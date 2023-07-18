<?php

namespace App\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'parent_id'=>'nullable|exists:categories,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'category_name_required',
            'name.min' => 'category_name_min',
            'parent_id.exists' => 'category_id_doesnt_exist',
        ];
    }
}
