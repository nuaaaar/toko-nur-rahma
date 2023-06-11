<?php

namespace App\Http\Requests\StockOpname;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockOpnameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('stock-opnames.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string',
            'date' => 'required|date',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
            'description' => 'nullable|string',
            'stock_opname_items' => 'required|array',
            'stock_opname_items.*.system' => 'required|integer',
            'stock_opname_items.*.physical' => 'required|integer',
            'stock_opname_items.*.returned_to_supplier' => 'required|integer',
            'stock_opname_items.*.description' => 'nullable|string',
            'stock_opname_items.*.product_id' => 'required|integer|exists:products,id',
        ];
    }
}
