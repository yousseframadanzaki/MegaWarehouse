<?php

namespace App\Area\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAreaRequest extends FormRequest
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
            'name'=>[
                'required',
                Rule::unique('areas', 'name')
            ],
            'price'=>[
                'required'
            ],
            'city_id'=>[
                'required'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'arae_name_required',
            'price.required' => 'arae_price_required',
            'city_id.required' => 'city_id_name_required',
        ];
    }
}
