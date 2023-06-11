@extends('layouts.dashboard')

@section('title', 'Laporan Stok')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Laporan Stok</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-4/12">
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
                    <div class="w-full md:w-7/12">
                        <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                            <div class="w-full md:w-1/3">
                                <select  name="filters[categories.name][]" class="form-control input-filter" data-filter-hidden="#filter-category">
                                    <option value="all" {{ in_array('all', request()->filters['categories.name'] ?? []) ? 'selected' : '' }}>Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->name }}" {{ in_array($category->name, request()->filters['categories.name'] ?? []) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full md:w-1/3">
                                <input type="date" name="date_from" class="form-control input-filter" value="{{ request()->date_from ?? '' }}">
                            </div>
                            <div class="w-full md:w-1/3">
                                <input type="date" name="date_to"  class="form-control input-filter" value="{{ request()->date_to ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/12">
                        <button type="submit" class="btn btn-primary w-full">Filter</button>
                    </div>
                </div>
            </form>
            <div class="grid grid-cols-2 md:flex gap-3 justify-center my-2">
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-secondary-600 p-2"></span>
                    <span class="text-xs">Jumlah Stok</span>
                </div>
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-fuchsia-600 p-2"></span>
                    <span class="text-xs">PO Dikirim</span>
                </div>
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-green-600 p-2"></span>
                    <span class="text-xs">Pengadaan Stok</span>
                </div>
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-primary-500 p-2"></span>
                    <span class="text-xs">Penjualan</span>
                </div>
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-blue-600 p-2"></span>
                    <span class="text-xs">Retur Customer</span>
                </div>
                <div class="inline-flex gap-1 items-center">
                    <span class="bg-red-600 p-2"></span>
                    <span class="text-xs">Toko Mengganti Barang Customer</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" style="width: 1%" >No</th>
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
                            @foreach ($dates as $date)
                                <th scope="col" class="text-center w-1/12">{{ date('m/d', strtotime($date)) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $product->category_name }}</td>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $product->name }}
                                </th>
                                @foreach ($dates as $date)
                                    @php
                                        $currentDateProductStock =  collect($product->filled_product_stocks)->where('date', $date)->first();
                                    @endphp
                                    <td class="font-bold text-center">
                                        @if ($currentDateProductStock)
                                            <div class="grid grid-cols-2 gap-y-0 gap-x-1 whitespace-nowrap">
                                                <div class="text-secondary-600">{{ $currentDateProductStock['stock'] }}</div>
                                                <div class="{{ $currentDateProductStock['delivery_order'] == 0 ? 'text-white' : 'text-fuchsia-500' }}">{{ 0 - $currentDateProductStock['delivery_order'] }}</div>
                                                <div class="{{ $currentDateProductStock['procurement'] == 0 ? 'text-white' : 'text-green-500' }}">{{ $currentDateProductStock['procurement'] }}</div>
                                                <div class="{{ $currentDateProductStock['sale'] == 0 ? 'text-white' : 'text-primary-500' }}">{{ 0 - $currentDateProductStock['sale'] }}</div>
                                                <div class="{{ $currentDateProductStock['return'] == 0 ? 'text-white' : 'text-blue-600' }}">{{ $currentDateProductStock['return'] }}</div>
                                                <div class="{{ $currentDateProductStock['change'] == 0 ? 'text-white' : 'text-red-600' }}">{{ 0 - $currentDateProductStock['change'] }}</div>
                                            </div>
                                        @else
                                            0
                                        @endif
                                    </td>
                                @endforeach
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
