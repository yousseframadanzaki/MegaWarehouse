<?php

namespace App\Categories\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $category_id = $this->route()->parameter('category_id');
        return [
            'name'=>[
                'required',
                'min:3',
            ],
            'parent_id'=>'nullable|exists:categories,id'
        ];
    }
}
