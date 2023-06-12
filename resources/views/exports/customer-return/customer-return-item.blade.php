@extends('layouts.export')

@section('title', 'Detail Retur Customer')

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
            @foreach ($customer_return_items as $customerReturnItem)
                <tr>
                    <td>{{ $customerReturnItem->customerReturn->invoice_number }}</td>
                    <td>{{ $customerReturnItem->product->name }}</td>
                    <td>{{ $customerReturnItem->product->unit }}</td>
                    <td>{{ $customerReturnItem->selling_price }}</td>
                    <td>{{ $customerReturnItem->qty }}</td>
                    <td>{{ $customerReturnItem->selling_price_total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($customer_return_items) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $customer_return_items->sum('selling_price_total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
