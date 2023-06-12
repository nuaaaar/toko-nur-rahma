@extends('layouts.export')

@section('title', 'Detail Penjualan')

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
            @foreach ($sale_items as $sale_item)
                <tr>
                    <td>{{ $saleItem->sale->invoice_number }}</td>
                    <td>{{ $saleItem->product->name }}</td>
                    <td>{{ $saleItem->product->unit }}</td>
                    <td>{{ $saleItem->selling_price }}</td>
                    <td>{{ $saleItem->qty }}</td>
                    <td>{{ $saleItem->selling_price_total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($sale_items) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $sale_items->sum('selling_price_total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
