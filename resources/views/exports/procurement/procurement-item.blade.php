@extends('layouts.export')

@section('title', 'Detail Pengadaan Stok')

@section('content')
    <table>
        <thead>
            <tr>
                <th>No. Invoice Agen</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($procurement_items as $procurement)
                <tr>
                    <td>{{ $procurement->procurement->invoice_number }}</td>
                    <td>{{ $procurement->product->name }}</td>
                    <td>{{ $procurement->product->unit }}</td>
                    <td>{{ $procurement->capital_price }}</td>
                    <td>{{ $procurement->qty }}</td>
                    <td>{{ $procurement->capital_price_total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($procurement_items) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $procurement_items->sum('capital_price_total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
