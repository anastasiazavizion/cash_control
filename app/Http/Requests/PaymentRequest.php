<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'amount'=>['required', 'numeric', 'min:1'],
           'payment_type_id'=>['required','exists:payment_types,id'],
           'payment_currency_id'=>['required','exists:payment_currencies,id'],
           'category_id'=>['required','exists:categories,id'],
           'payment_date'=>['nullable'],
           'description'=>['nullable'],
        ];
    }
}
