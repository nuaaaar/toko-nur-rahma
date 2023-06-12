@extends('layouts.export')

@section('title', 'Data Produk')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Barcode (Agen)</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Diperbarui Pada</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->unit }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->capital_price }}</td>
                    <td>{{ $product->selling_price }}</td>
                    <td>{{ $product->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
