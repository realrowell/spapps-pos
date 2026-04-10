<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StorePrStockInputRequest extends FormRequest
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
            'product' => 'required|string|exists:products,pr_code',
            'location' => 'required|string|exists:locations,loc_code',
            'quantity' => 'required|numeric|min:1',
            'unit_cost' => 'required|numeric|min:0.01',
            'remarks' => 'nullable|string|max:255',
        ];
    }
}
