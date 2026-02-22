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
            'short_desc' => 'nullable|string|max:255',
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
            'stock' => 'nullable|integer|min:0',
            'stock_location' => 'nullable',
            'sku' => 'nullable|string',
            'barcode' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'warranty' => 'nullable|string',
            'alert_threshold' => 'nullable|integer',
            'track_inventory' => 'nullable|boolean'
        ];
    }

    public function messages(): array
{
    return [
        'short_desc.max' => 'The description must not exceed 255 characters.',

        'name.required' => 'Product name is required.',

        'price.required' => 'Price is required.',

        'price.numeric' => 'Price must be a valid number.',

        'thumbnail.image' => 'Thumbnail must be an image file.',

        'price_effective_to.after_or_equal' =>
            'Effective To must be after or equal to Effective From.',
    ];
}
}
