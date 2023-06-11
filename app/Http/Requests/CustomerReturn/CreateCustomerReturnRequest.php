<?php

namespace App\Http\Requests\CustomerReturn;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerReturnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('customer-returns.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'sale_id' => 'required|exists:sales,id',
            'date' => 'required|date_format:Y-m-d',
            'category' => 'required|in:ganti barang,refund pembayaran',
            'total' => 'required|numeric',
            'customer_return_items' => 'required|array',
        ];
    }

    /**
     * Define custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'sale_id' => 'Invoice Penjualan',
            'date' => 'Tanggal Pengembalian',
            'category' => 'Kategori',
            'total' => 'Total',
            'customer_return_items' => 'Barang Dikembalikan',
        ];
    }
}
