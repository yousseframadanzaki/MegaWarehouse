<?php

namespace App\Clients\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'links'=>'nullable',
            'client_group_id'=>'nullable|exists:client_groups,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'name_required',
            'name.min'=>'name_required',
            'phone_1.required'=>'phone_1_required',
            'phone_1.min'=>'phone_1_min',
            'phone_2.min'=>'phone_2_min',
            'address.required'=>'address_required',
            'country_id.required'=>'country_id_required',
            'country_id.exists'=>'country_id_exists',
            'city_id.required'=>'city_id_required',
            'city_id.exists'=>'city_id_exists',
            'area_id.required'=>'area_id_required',
            'area_id.exists'=>'area_id_exists',
            'client_group_id.exists'=>'client_groups_exists',
        ];
    }   
}
