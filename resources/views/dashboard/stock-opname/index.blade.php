@extends('layouts.dashboard')

@section('title', 'Stock Opname')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Stock Opname</span>
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
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="fal fa-search"></i>
                            </div>
                            <input type="text" name="search" id="simple-search" class="form-control" placeholder="Cari" value="{{ request()->search }}">
                        </div>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        @can('delivery-orders.create')
                            <a href="javascript:;" class="btn btn-primary" id="btn-create">
                                <i class="fas fa-plus"></i>
                                <span> Stock Opname </span>
                            </a>
                        @endcan
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" style="width: 1%">Judul</th>
                            <th scope="col" class="whitespace-nowrap" style="width: 1%">Tanggal SO</th>
                            <th scope="col" class="text-right" style="width: 1%">Aktual</th>
                            <th scope="col" class="text-right" style="width: 1%">Sistem</th>
                            <th scope="col" class="text-right" style="width: 1%">Selisih</th>
                            <th class="text-right" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody data-accordion="collapse">
                        @forelse ($stock_opnames as $stockOpname)
                            @php
                                $totalActual = $stockOpname->stockOpnameItems->sum('physical') + $stockOpname->stockOpnameItems->sum('returned_to_supplier');
                            @endphp
                            <tr>
                                <th class="cursor-pointer hover:bg-gray-100 font-medium text-gray-900 whitespace-nowrap dark:text-white"  data-accordion-target="#accordion-permissions-{{ $stockOpname->id }}" aria-controls="accordion-permissions-{{ $stockOpname->id }}" aria-expanded="false">
                                    <div class="flex justify-between w-full">
                                        <span>{{ $stockOpname->title }} (Periode: {{ $stockOpname->date_from }} s/d {{ $stockOpname->date_to }})</span>
                                        <span>
                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </span>
                                    </div>
                                </th>
                                <td>{{ $stockOpname->date }}</td>
                                <td class="text-right">{{ number_format($totalActual, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($stockOpname->stockOpnameItems->sum('system'), 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($stockOpname->stockOpnameItems->sum('difference'), 0, ',', '.') }}</td>
                                <td >
                                    <div class="flex items-center space-x-3">
                                        @can('stock-opnames.update')
                                            <a href="{{ route('dashboard.stock-opname.edit', $stockOpname->id) }}" class="btn btn-text">
                                                <i class="fas fa-pencil"></i>
                                                <span> Edit </span>
                                            </a>
                                        @endcan
                                        @can('stock-opnames.delete')
                                            <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.stock-opname.destroy', $stockOpname->id) }}">
                                                <i class="fas fa-trash"></i>
                                                <span> Hapus </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            <tr id="accordion-permissions-{{ $stockOpname->id }}" class="hidden">
                                <th colspan="2" class="cursor-pointer hover:bg-gray-100 font-medium text-gray-900 dark:text-white"  data-accordion-target="#accordion-permissions-{{ $stockOpname->id }}" aria-controls="accordion-permissions-{{ $stockOpname->id }}" aria-expanded="false">
                                    <div class="flex flex-col gap-3">
                                        @foreach ($stockOpname->stockOpnameItems as $stockOpnameItem)
                                            <span class="block whitespace-nowrap">{{ $stockOpnameItem->product->name }}</span>
                                        @endforeach
                                    </div>
                                </th>
                                <td class="text-right">
                                    <div class="flex flex-col gap-3">
                                        @foreach ($stockOpname->stockOpnameItems as $stockOpnameItem)
                                            <span class="block whitespace-nowrap">{{ number_format($stockOpnameItem->physical + $stockOpnameItem->returned_to_supplier, 0, ',', '.') }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="flex flex-col gap-3">
                                        @foreach ($stockOpname->stockOpnameItems as $stockOpnameItem)
                                            <span class="block whitespace-nowrap">{{ number_format($stockOpnameItem->system, 0, ',', '.') }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="flex flex-col gap-3">
                                        @foreach ($stockOpname->stockOpnameItems as $stockOpnameItem)
                                            <span class="block whitespace-nowrap">{{ number_format($stockOpnameItem->difference, 0, ',', '.') }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="flex flex-col gap-3">
                                        @foreach ($stockOpname->stockOpnameItems as $stockOpnameItem)
                                            <span class="block whitespace-nowrap {{ $stockOpnameItem->description == null ? 'text-white' : '' }}">{{ $stockOpnameItem->description ?? '-' }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-0">
                                <td colspan="3" class="text-center">
                                    @include('components.empty-state.table')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.delivery-order.destroy', ['delivery_order' => 0]) }}" method="POST" class="hidden">
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

                    <form action="{{ route('dashboard.delivery-order.create') }}">
                        <div class="mb-5">
                            <h5 class="text-lg text-black font-medium">Tambah Stock Opname</h5>
                        </div>
                        <div>
                            <label class="label-block text-left">No. Invoice Purchase Order</label>
                            <input type="text" name="invoice_number" class="form-control" placeholder="PO/2023/01/02/034567" required>
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
