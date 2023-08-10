<?php

namespace App\Stock\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $operation_ids = $this->request->all()['opertation_ids'];
        if($this->user()->can('destroy',['App\\Models\Stock',$operation_ids])){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

        ];
    }

    public function messages()
    {
        return [

        ];
    }

}
