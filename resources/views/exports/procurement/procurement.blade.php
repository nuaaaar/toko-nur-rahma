@extends('layouts.export')

@section('title', 'Pengadaan Stok')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Tanggal Pengadaan</th>
                <th>No. Invoice Agen</th>
                <th>Nama Agen</th>
                <th>NPWP Agen</th>
                <th>Pajak(%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($procurements as $procurement)
                <tr>
                    <td>{{ $procurement->date }}</td>
                    <td>{{ $procurement->invoice_number }}</td>
                    <td>{{ $procurement->supplier->name }}</td>
                    <td>{{ $procurement->supplier->tin }}</td>
                    <td>{{ $procurement->tax }}</td>
                    <td>{{ $procurement->total }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($procurements) > 0)
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ $procurements->sum('total') }}</th>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
