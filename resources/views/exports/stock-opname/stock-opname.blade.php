@extends('layouts.export')

@section('title', 'Stock Opname')

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal SO</th>
                <th>Periode</th>
                <th>Judul</th>
                <th>Aktual</th>
                <th>Sistem</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stock_opnames as $stockOpname)
                <tr>
                    <td>SO{{ $stockOpname->id }}</td>
                    <td>{{ $stockOpname->date }}</td>
                    <td>{{ $stockOpname->date_from }} s/d {{ $stockOpname->date_to }}</td>
                    <td>{{ $stockOpname->title }}</td>
                    <td>{{ $stockOpname->stockOpnameItems->sum('physical') + $stockOpname->stockOpnameItems->sum('returned_to_supplier') }}</td>
                    <td>{{ $stockOpname->stockOpnameItems->sum('system') }}</td>
                    <td>{{ $stockOpname->stockOpnameItems->sum('difference') }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($stock_opnames) > 0)
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td></td>
                    <td></td>
                    <td>{{ $stock_opnames->sum(function ($stockOpname) { return $stockOpname->stockOpnameItems->sum('physical') + $stockOpname->stockOpnameItems->sum('returned_to_supplier'); }) }}</td>
                    <td>{{ $stock_opnames->sum(function ($stockOpname) { return $stockOpname->stockOpnameItems->sum('system'); }) }}</td>
                    <td>{{ $stock_opnames->sum(function ($stockOpname) { return $stockOpname->stockOpnameItems->sum('difference'); }) }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
