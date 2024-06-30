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
            'client.name'=>'required|min:3',
            'client.phone_1'=>'required|min:11',
            'client.phone_2'=>'nullable',
            'client.address'=>'required|min:10',
            'client.country_id'=>'required|exists:countries,id',
            'client.city_id'=>'required|exists:cities,id',
            'client.area_id'=>'required|exists:areas,id',
            'marketer_id'=>'nullable|exists:marketers,id',
            'items'=>'required|array|min:1',
            'items.*.warehouse_id'=>'required|exists:warehouses,id',
            'items.*.quantity'=>'required|numeric|gt:0',
        ];
    }

    public function messages()
    {
        return [

        ];
    }

}
