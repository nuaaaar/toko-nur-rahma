@extends('layouts.dashboard')

@section('title', 'Tambah Jenis Barang')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.product.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Jenis Barang</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah Jenis Barang</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.product.store') }}" method="POST">
                @csrf
                <div class="flex flex-col md:grid  md:grid-cols-2 gap-4 mt-0">
                    <div class="col-span-2">
                        <label class="label-block">Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="name" class="label-block">Nama Barang</label>
                        <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror form-control" placeholder="" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="unit" class="label-block">Satuan</label>
                        <input type="text" name="unit" id="unit" class="@error('unit') is-invalid @enderror form-control" placeholder="" value="{{ old('unit') }}" required>
                        @error('unit')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="product_code" class="label-block">Kode Barang</label>
                        <input type="text" name="product_code" id="product_code" class="@error('product_code') is-invalid @enderror form-control" placeholder="" value="{{ old('product_code') }}" required>
                        @error('product_code')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="barcode" class="label-block">Barcode</label>
                        <input type="text" name="barcode" id="barcode" class="@error('barcode') is-invalid @enderror form-control" placeholder="" value="{{ old('barcode') }}">
                        @error('barcode')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="capital_price" class="label-block">Harga Modal(Rp)</label>
                        <input type="text" name="capital_price" id="capital_price" class="@error('capital_price') is-invalid @enderror form-control currency !text-left" placeholder="" value="{{ old('capital_price') }}" required>
                        @error('capital_price')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="selling_price" class="label-block">Harga Jual(Rp)</label>
                        <input type="text" name="selling_price" id="selling_price" class="@error('selling_price') is-invalid @enderror form-control currency !text-left" placeholder="" value="{{ old('selling_price') }}" required>
                        @error('selling_price')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary" id="btn-create">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function ()
        {
            let targetUrl = baseUrl + '/dashboard/product';
            markActiveMenu(targetUrl);
        });
    </script>
@endpush
