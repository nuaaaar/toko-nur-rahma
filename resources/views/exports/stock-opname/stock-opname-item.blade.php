@extends('layouts.export')

@section('title', 'Detail Stock Opname')

@section('content')
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal SO</th>
                <th>Nama Brang</th>
                <th>Fisik</th>
                <th>Retur Supplier</th>
                <th>Aktual</th>
                <th>Sistem</th>
                <th>Selisih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stock_opname_items as $stockOpnameItem)
                <tr>
                    <td>SO{{ $stockOpnameItem->stock_opname_id }}</td>
                    <td>{{ $stockOpnameItem->product->name }}</td>
                    <td>{{ $stockOpnameItem->physical }}</td>
                    <td>{{ $stockOpnameItem->returned_to_supplier }}</td>
                    <td>{{ $stockOpnameItem->physical + $stockOpnameItem->returned_to_supplier }}</td>
                    <td>{{ $stockOpnameItem->system }}</td>
                    <td>{{ $stockOpnameItem->difference }}</td>
                </tr>
            @endforeach
        </tbody>
        @if (count($stock_opname_items) > 0)
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td></td>
                    <td></td>
                    <td>{{ $stock_opname_items->sum('physical') + $stock_opname_items->sum('returned_to_supplier') }}</td>
                    <td>{{ $stock_opname_items->sum('system') }}</td>
                    <td>{{ $stock_opname_items->sum('difference') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
