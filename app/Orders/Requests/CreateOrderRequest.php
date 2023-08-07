<?php

namespace App\Orders\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
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
            'phone_1'=>'required|min:11',
            'phone_2'=>'nullable|min:11',
            'address'=>'required|min:10',
            'country_id'=>'required|exists:countries,id',
            'city_id'=>'required|exists:cities,id',
            'area_id'=>'required|exists:areas,id',
            'items'=>'required|array|min:1',
            'items.*.id'=>'required|exists:variants,id',
            'items.*.warehouse'=>'required|exists:warehouses,id',
            'items.*.quantity'=>'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [

        ];
    }

}
