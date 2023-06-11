<?php

namespace App\Http\Requests\Sale;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('sales.update');
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
            'customer.name' => 'required|string',
            'customer.phone_number' => 'required|string',
            'date' => 'required|date',
            'sale_items' => 'required|array',
            'payment_method' => 'required|string',
            'total' => 'required|numeric',
            'total_paid' => 'required|numeric',
            'total_change' => 'required|numeric',
        ];
    }

    /**
     * Define custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'Pengguna',
            'customer_name' => 'Nama Customer',
            'customer_phone_number' => 'Nomor Telepon Customer',
            'date' => 'Tanggal',
            'sale_items' => 'Barang',
            'payment_method' => 'Metode Pembayaran',
            'total' => 'Total',
            'total_paid' => 'Total Dibayar',
            'total_change' => 'Kembalian',
        ];
    }
}
