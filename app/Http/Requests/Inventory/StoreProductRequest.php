<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable',
            'brand' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'uom' => 'required|string',
            'status' => 'required|string',
            'price_type' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_effective_from' => 'nullable|date',
            'price_effective_to' => 'nullable|date|after_or_equal:price_effective_from',
            'stock' => 'required|integer|min:0',
            'stock_location' => 'nullable',
        ];
    }
}
