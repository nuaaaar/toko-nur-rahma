@extends('layouts.export')

@section('title', 'Retur Customer')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Tanggal Retur</th>
                <th>No. Invoice Retur</th>
                <th>No. Invoice Penjualan</th>
                <th>Nama Customer</th>
                <th>Nomor Telepon Customer</th>
                <th>Alamat Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer_returns as $customerReturn)
                <tr>
                    <td>{{ $customerReturn->date }}</td>
                    <td>{{ $customerReturn->invoice_number }}</td>
                    <td>{{ $customerReturn->sale->invoice_number }}</td>
                    <td>{{ $customerReturn->customer->name }}</td>
                    <td>{{ $customerReturn->customer->phone_number }}</td>
                    <td>{{ $customerReturn->customer->address }}</td>
                    <td>{{ $customerReturn->total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($customer_returns) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $customer_returns->sum('total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
