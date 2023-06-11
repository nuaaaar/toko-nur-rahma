<?php

namespace App\Http\Requests\PurchaseOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('purchase-orders.create');
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
            'customer.address' => 'required|string',
            'date' => 'required|date',
            'purchase_order_items' => 'required|array',
            'status' => 'required|in:menunggu,diproses,dibatalkan,selesai',
            'total' => 'required|numeric',
        ];
    }

    /**
     * Define custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'Pengguna',
            'customer.name' => 'Nama Customer',
            'customer.phone_number' => 'Nomor Telepon Customer',
            'customer.address' => 'Alamat Customer',
            'date' => 'Tanggal',
            'purchase_order_items' => 'Barang',
            'status' => 'Status',
            'total' => 'Total',
        ];
    }
}
