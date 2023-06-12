@extends('layouts.export')

@section('title', 'Detail Purchase Order')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase_order_items as $purchaseOrder)
                <tr>
                    <td>{{ $purchaseOrder->purchaseOrder->invoice_number }}</td>
                    <td>{{ $purchaseOrder->product->name }}</td>
                    <td>{{ $purchaseOrder->product->unit }}</td>
                    <td>{{ $purchaseOrder->selling_price }}</td>
                    <td>{{ $purchaseOrder->qty }}</td>
                    <td>{{ $purchaseOrder->selling_price_total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($purchase_order_items) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $purchase_order_items->sum('selling_price_total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
