<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('products.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'product_code' => 'required|unique:products,product_code,NULL,id,deleted_at,NULL',
            'unit' => 'required',
            'capital_price' => 'required',
            'selling_price' => 'required',
        ];
    }
}
