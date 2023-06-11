<?php

namespace App\Http\Requests\DeliveryOrder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->can('delivery-orders.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'date' => 'required|date_format:Y-m-d',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone_number' => 'required|string|max:255',
            'receiver_address' => 'required|string|max:255',
            'delivery_order_items' => 'required|array',
        ];
    }

    /**
     * Define custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'purchase_order_id' => 'Invoice Purchase Order',
            'date' => 'Tanggal Pengembalian',
            'receiver_name' => 'Nama Penerima',
            'receiver_phone_number' => 'Nomor Telepon Penerima',
            'receiver_address' => 'Alamat Penerima',
            'delivery_order_items' => 'Barang Dikembalikan',
        ];
    }
}
