@extends('layouts.export')

@section('title', 'Purchase Order')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Tanggal PO</th>
                <th>No. Invoice</th>
                <th>Status</th>
                <th>Nama Customer</th>
                <th>Nomor Telepon Customer</th>
                <th>Alamat Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchase_orders as $purchaseOrders)
                <tr>
                    <td>{{ $purchaseOrders->date }}</td>
                    <td>{{ $purchaseOrders->invoice_number }}</td>
                    <td>{{ $purchaseOrders->status }}</td>
                    <td>{{ $purchaseOrders->customer->name }}</td>
                    <td>{{ $purchaseOrders->customer->phone }}</td>
                    <td>{{ $purchaseOrders->customer->address }}</td>
                    <td>{{ $purchaseOrders->total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($purchase_orders) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $purchase_orders->sum('total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
