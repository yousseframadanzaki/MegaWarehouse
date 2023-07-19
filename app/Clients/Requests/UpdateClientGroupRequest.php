<?php

namespace App\Clients\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientGroupRequest extends FormRequest
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
        $client_group_id = $this->route()->parameter('client_group_id');
        return [
            'name'=>[
                'required',
                'min:3',
                Rule::unique('client_groups', 'name')
                ->where('company_id', auth()->user()->company_id)
                ->ignore($client_group_id,'id')
            ],
            'discount'=>'required|numeric|between:0,100.00'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'group_name_required',
            'name.min'=>'group_name_min',
            'name.unique'=>'group_name_unique',
            'discount.required'=>'group_discount_required',
            'discount.numeric'=>'group_discount_numeric',
            'discount.between'=>'group_discount_numeric',
        ];
    }   
}
