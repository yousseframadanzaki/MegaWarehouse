<?php

namespace App\Invoices\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayInvoiceRequest extends FormRequest
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
            'from'=>'required|exists:users,id',
            'value'=>'required|gt:0',
            'note'=>'nullable',
            // 'image'=>'file|max:10240|mimes:jpg,bmp,png'
        ];
    }
}
