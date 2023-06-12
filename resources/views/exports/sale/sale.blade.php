@extends('layouts.export')

@section('title', 'Penjualan')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Tanggal Penjualan</th>
                <th>No. Invoice</th>
                <th>Nama Customer</th>
                <th>Nomor Telepon Customer</th>
                <th>Alamat Customer</th>
                <th>Metode Pembayaran</th>
                <th>Bank</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->customer->phone_number }}</td>
                    <td>{{ $sale->customer->address }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>{{ $sale->bank->name ?? '' }}</td>
                    <td>{{ $sale->total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($sales) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $sales->sum('total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
