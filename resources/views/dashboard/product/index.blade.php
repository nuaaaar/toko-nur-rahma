@extends('layouts.dashboard')

@section('title', 'Jenis Barang')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Jenis Barang</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-3/5">
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
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <i class="fa fa-filter w-4 h-4 mr-2"></i>
                            Filter
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown"
                            class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                Kategori
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                @foreach ($categories as $key => $category)
                                    <li class="flex items-center">
                                        <input id="checkbox-category-{{ $key }}" type="checkbox" name="filters[categories.name][]" value="{{ $category->name }}"
                                            class="custom-checkbox" {{ in_array($category->name, request()->filters['categories.name'] ?? []) ? 'checked' : '' }} />
                                        <label for="checkbox-category-{{ $key }}"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $category->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="btn btn-sm btn-primary w-full mt-2">Terapkan</button>
                        </div>
                        @can('products.create')
                            <a href="{{ route('dashboard.product-import.index') }}" class="btn btn-primary">
                                <i class="fas fa-download"></i>
                                <span> Import </span>
                            </a>
                        @endcan
                        @can('products.create')
                            <a href="{{ route('dashboard.product.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span> Jenis Barang </span>
                            </a>
                        @endcan
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'product_code', 'orderType' => request()->orderBy == 'product_code' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center gap-x-1">
                                    Kode
                                    <i class="fa {{ request()->orderBy != 'product_code' ? 'fa-sort' : (request()->orderBy == 'product_code' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'name', 'orderType' => request()->orderBy == 'name' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center gap-x-1">
                                    Nama Barang
                                    <i class="fa {{ request()->orderBy != 'name' ? 'fa-sort' : (request()->orderBy == 'name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'category_name', 'orderType' => request()->orderBy == 'category_name' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Kategori
                                    <i class="fa {{ request()->orderBy != 'category_name' ? 'fa-sort' : (request()->orderBy == 'category_name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'unit', 'orderType' => request()->orderBy == 'unit' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Satuan
                                    <i class="fa {{ request()->orderBy != 'unit' ? 'fa-sort' : (request()->orderBy == 'unit' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col" class="text-right">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'capital_price', 'orderType' => request()->orderBy == 'capital_price' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Harga Modal(Rp)
                                    <i class="fa {{ request()->orderBy != 'capital_price' ? 'fa-sort' : (request()->orderBy == 'capital_price' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col" class="text-right">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'selling_price', 'orderType' => request()->orderBy == 'selling_price' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Harga Jual(Rp)
                                    <i class="fa {{ request()->orderBy != 'selling_price' ? 'fa-sort' : (request()->orderBy == 'selling_price' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>
                                    <a class="text-primary-600 font-medium cursor-pointer barcode-print" href="{{ route('dashboard.product.barcode', $product->id) }}" target="_blank">
                                        {{ $product->product_code }}
                                    </a>
                                </td>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $product->name }}
                                </th>
                                <td>{{ $product->category_name ?? '' }}</td>
                                <td>{{ $product->unit }}</td>
                                <td class="text-right">{{ number_format($product->capital_price, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td style="width: 1%">
                                    <div class="flex items-center justify-end space-x-3">
                                        @can('products.update')
                                            <a href="{{ route('dashboard.product.edit', $product->id) }}" class="btn btn-text">
                                                <i class="fas fa-pencil"></i>
                                                <span> Edit </span>
                                            </a>
                                        @endcan
                                        @can('products.delete')
                                            <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.product.destroy', $product->id) }}">
                                                <i class="fas fa-trash"></i>
                                                <span> Hapus </span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-0">
                                <td colspan="7" class="text-center">
                                    @include('components.empty-state.table')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $products->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.product.destroy', ['product' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function ()
        {
            $(document).on('click', '.btn-delete', function ()
            {
                let url = $(this).data('url');
                showConfirmDialog('Apakah anda yakin ingin menghapus data ini?', function ()
                {
                    let deleteForm = $('#form-delete');
                    deleteForm.attr('action', url);
                    deleteForm.submit();
                });
            });

        });
    </script>
@endpush
