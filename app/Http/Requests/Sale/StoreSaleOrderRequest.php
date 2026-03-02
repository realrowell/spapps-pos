<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleOrderRequest extends FormRequest
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
            'products' => ['required', 'array'],
            'products.*.pr_code' => ['required', 'exists:products,pr_code'],
            'products.*.qty' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'exists:payment_providers,provider_code'],
            'so_number' => 'nullable|string'
        ];
    }
}
