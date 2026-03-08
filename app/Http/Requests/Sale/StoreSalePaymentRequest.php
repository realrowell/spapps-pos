<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalePaymentRequest extends FormRequest
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
            'payment' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string' , 'exists:payment_providers,provider_code'],
            'sale_id' => ['required', 'string', 'exists:sales,sale_ref'],
            'external_transaction_id' => ['nullable','string'],
            'reference_no' => ['nullable','string'],
        ];
    }
}
