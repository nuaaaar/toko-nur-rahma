@extends('layouts.dashboard')

@section('title', 'Stok Kosong')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Stok Kosong</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-7/12">
                        <input type="hidden" name="orderBy" value="{{ request()->orderBy }}">
                        <input type="hidden" name="orderType" value="{{ request()->orderType }}">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="fal fa-search"></i>
                            </div>
                            <input type="text" name="search" id="simple-search" class="form-control" placeholder="Cari" value="{{ request()->search }}">
                        </div>
                    </div>
                    <div class="w-full md:w-4/12">
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                            <div class="w-full md:w-1/3">
                                <select  name="filters[categories.name][]" class="form-control input-filter" data-filter-hidden="#filter-category">
                                    <option value="all" {{ in_array('all', request()->filters['categories.name'] ?? []) ? 'selected' : '' }}>Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}" {{ in_array($category->name, request()->filters['categories.name'] ?? []) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <button type="submit" class="btn btn-primary w-full">Filter</button>
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="text-center">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'product_code', 'orderType' => request()->orderBy == 'product_code' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Kode Barang
                                    <i class="fa {{ request()->orderBy != 'product_code' ? 'fa-sort' : (request()->orderBy == 'product_code' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col" class="text-center" style="width: 1%">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'category_name', 'orderType' => request()->orderBy == 'category_name' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Kategori
                                    <i class="fa {{ request()->orderBy != 'category_name' ? 'fa-sort' : (request()->orderBy == 'category_name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'name', 'orderType' => request()->orderBy == 'name' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center gap-x-1">
                                    Nama Barang
                                    <i class="fa {{ request()->orderBy != 'name' ? 'fa-sort' : (request()->orderBy == 'name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th class="text-center whitespace-nowrap">Stok</th>
                            <th class="text-center whitespace-nowrap" style="width: 1%">Terakhir Diupdate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="text-center">{{ $product->product_code }}</td>
                                <td class="text-center whitespace-nowrap">{{ $product->category->name }}</td>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $product->name }}
                                </th>
                                <td class="text-center">{{ $product->latestProductStock->stock ?? 0 }}</td>
                                <td class="text-center">{{ ($product->latestProductStock->updated_at ?? null) != null ? $product->latestProductStock->updated_at->format('Y-m-d H:i') : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
    </script>
@endpush
