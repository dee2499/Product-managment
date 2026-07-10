<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $product = $this->route('product');

        return $this->user() !== null && $product instanceof Product && $this->user()->can('update', $product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99', 'decimal:0,2'],
            'date_available' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The product title is required.',
            'title.string' => 'The product title must be a valid string.',
            'title.max' => 'The product title may not be greater than 255 characters.',
            'description.required' => 'The product description cannot be empty.',
            'price.required' => 'Please specify a price for the product.',
            'price.numeric' => 'The product price must be a valid number.',
            'price.min' => 'The product price must be at least 0.00.',
            'price.max' => 'The product price may not exceed 99,999,999.99.',
            'price.decimal' => 'The product price must have up to 2 decimal places.',
            'date_available.required' => 'Please select the date when the product becomes available.',
            'date_available.date' => 'The availability date must be a valid date.',
            'date_available.date_format' => 'The availability date must match the format YYYY-MM-DD.',
        ];
    }
}
