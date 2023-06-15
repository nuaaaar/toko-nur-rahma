@extends('layouts.dashboard')

@section('title', 'Retur Customer')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Retur Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="" id="form-search">
                <div class="flex flex-col md:flex-row items-center justify-between gap-y-4 md:space-x-4 p-4">
                    <div class="w-full md:w-3/4">
                        <input type="hidden" name="orderBy" id="filter-orderBy" value="{{ request()->orderBy }}">
                        <input type="hidden" name="orderType" id="filter-orderType" value="{{ request()->orderType }}">
                        <input type="hidden" name="filters[customer_id]" id="filter-customer-id" value="{{ request()->filters['customer_id'] ?? '' }}">
                        <input type="hidden" name="filters[date_from]" id="filter-date-from" value="{{ request()->filters['date_from'] ?? '' }}">
                        <input type="hidden" name="filters[date_to]" id="filter-date-to" value="{{ request()->filters['date_to'] ?? '' }}">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="fal fa-search"></i>
                            </div>
                            <input type="text" name="search" id="simple-search" class="form-control" placeholder="Cari" value="{{ request()->search }}">
                        </div>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        @can('customer-returns.create')
                            <a href="javascript:;" class="btn btn-primary" id="btn-create">
                                <i class="fas fa-plus"></i>
                                <span> Retur Customer </span>
                            </a>
                        @endcan
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="flex flex-col md:grid md:grid-cols-12 gap-4 mt-5">
        <div class="md:col-span-4 p-4">
            <div class="flex flex-col space-y-2">
                <div>
                    <h1 class="font-medium mb-3">
                        <i class="fas fa-filter"></i>
                        <span class="ml-2"> Filter </span>
                    </h1>
                </div>
                <div>
                    <label class="block mb-2">Customer</label>
                    <select class="form-control input-filter init-select2" placeholder="Pilih Customer" data-filter-hidden="#filter-customer-id" allow-clear="true">
                        <option></option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request()->filters['customer_id'] ?? '' == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2">Tanggal</label>
                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                        <div class="w-full md:w-1/2">
                            <input type="date" class="form-control input-filter" value="{{ request()->filters['date_from'] ?? '' }}" data-filter-hidden="#filter-date-from">
                        </div>
                        <div class="w-full md:w-1/2">
                            <input type="date"  class="form-control input-filter" value="{{ request()->filters['date_to'] ?? '' }}" data-filter-hidden="#filter-date-to">
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-primary w-full mt-2" id="btn-filter">Terapkan</button>
                </div>
            </div>
        </div>
        <div class="md:col-span-8 space-y-3">
            <div class="flex gap-x-2 items-center w-1/1">
                <span class="mr-3 hidden md:block">Urutkan</span>
                <div class="w-2/3 md:w-auto">
                    <select name="orderBy" class="form-control form-control-sm input-sort" data-filter-hidden="#filter-orderBy">
                        <option value="date" {{ request()->orderBy == 'date' ? 'selected' : '' }}>Tanggal</option>
                        <option value="customers.name" {{ request()->orderBy == 'customers.name' ? 'selected' : '' }}>Customer</option>
                        <option value="total" {{ request()->orderBy == 'total' ? 'selected' : '' }}>Harga</option>
                    </select>
                </div>
                <div class="w-1/3 md:w-auto">
                    <select name="orderType" class="form-control form-control-sm input-sort" data-filter-hidden="#filter-orderType">
                        <option value="asc" {{ request()->orderType == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request()->orderType == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>
            </div>
            @forelse ($customer_returns as $customer_return)
                <div class="card">
                    <div class="card-header">
                        <div class="flex flex-wrap justify-center md:justify-between items-center">
                            <div class="w-full md:w-auto text-center md:text-left">
                                <h4 class="font-bold mb-0">{{ $customer_return->customer->name ?? 'Data tidak tersedia' }}</h4>
                                <p class="mb-0">{{ $customer_return->invoice_number }}</p>
                            </div>
                            <div class="text-center flex flex-col-reverse items-center md:block md:text-right">
                                <div class="badge badge-danger uppercase text-sm">{{ $customer_return->category }}</div>
                                <p class="mb-0">{{ $customer_return->sale->invoice_number }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="w-full">
                            <tbody>
                                @foreach ($customer_return->customerReturnItems as $customerReturnItem)
                                    <tr>
                                        <td colspan="2" class="font-medium">{{ $customerReturnItem->product->name ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <td>x{{ number_format($customerReturnItem->qty, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp{{ number_format($customerReturnItem->selling_price_total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="flex flex-col md:grid md:grid-cols-2 md:items-center">
                            <div class="flex items-center space-x-3 justify-end md:justify-start">
                                <a href="{{ route('dashboard.customer-return.invoice', $customer_return->id) }}" class="btn btn-text" target="_blank">
                                    <i class="fas fa-print"></i>
                                    <span> Print </span>
                                </a>
                                @can('customer-returns.update')
                                    <a href="{{ route('dashboard.customer-return.edit', $customer_return->id) }}" class="btn btn-text">
                                        <i class="fas fa-pencil"></i>
                                        <span> Edit </span>
                                    </a>
                                @endcan
                                @can('customer-returns.delete')
                                    <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.customer-return.destroy', $customer_return->id) }}">
                                        <i class="fas fa-trash"></i>
                                        <span> Hapus </span>
                                    </button>
                                @endcan
                            </div>
                            <div class="flex items-center justify-end space-x-4 order-first md:order-last">
                                <div class="flex space-x-1 text-xs text-gray-400 items-center">
                                    <span>Total</span>
                                </div>
                                <div>
                                    <span class="font-bold text-primary-600 text-lg">Rp{{ number_format($customer_return->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-xs">Diperbarui pada <span class="text-primary-600">{{ $customer_return->updated_at->format('Y-m-d H:i') }}</span> oleh <span class="text-primary-600">{{ $customer_return->user->name }}</span></p>
                        </div>
                    </div>
                </div>
            @empty
                @include('components.empty-state.card')
            @endforelse
            {{ $customer_returns->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.customer-return.destroy', ['customer_return' => 0]) }}" method="POST" class="hidden">
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

            $(document).on('change', '.input-filter', function()
            {
                let targetHidden = $(this).data('filter-hidden');
                let value = $(this).val();

                $(targetHidden).val(value);
            });

            $(document).on('change', '.input-sort', function()
            {
                let targetHidden = $(this).data('filter-hidden');
                let value = $(this).val();

                $(targetHidden).val(value);
                $("#form-search").submit();
            });

            $(document).on('click', '#btn-filter', function()
            {
                $("#form-search").submit();
            });

            $(document).on('click', '#btn-create', function()
            {
                showFormDialog(null, `

                    <form action="{{ route('dashboard.customer-return.create') }}">
                        <div class="mb-5">
                            <h5 class="text-lg text-black font-medium">Tambah Retur Customer</h5>
                        </div>
                        <div>
                            <label class="label-block text-left">No. Invoice Penjualan</label>
                            <input type="text" name="invoice_number" class="form-control" placeholder="INV/2023/01/02/034567" required>
                        </div>
                        <button type="submit" id="btn-submit-create" style="display: none;"></button>
                    </form>
                `, () => {
                    $(document).find('#btn-submit-create').click();
                    if ($('input[name="invoice_number"]').val() == '') {
                        return false;
                    }
                })
            });
        });

    </script>
@endpush
