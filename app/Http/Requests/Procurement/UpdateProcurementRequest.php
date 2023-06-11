<?php

namespace App\Http\Requests\Procurement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProcurementRequest extends FormRequest
{
   /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('procurements.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'procurement_items' => 'required|array',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric|max:100',
            'total' => 'required|numeric'
        ];
    }

    /**
     * Define custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'Pengguna',
            'supplier_id' => 'Agen',
            'date' => 'Tanggal',
            'procurement_items' => 'Barang',
            'subtotal' => 'Subtotal',
            'tax' => 'Pajak',
            'total' => 'Total'
        ];
    }
}
