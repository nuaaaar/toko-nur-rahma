@extends('layouts.dashboard')

@section('title', 'Surat Jalan')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Surat Jalan</span>
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
                        @can('delivery-orders.create')
                            <a href="javascript:;" class="btn btn-primary" id="btn-create">
                                <i class="fas fa-plus"></i>
                                <span> Surat Jalan </span>
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
                        <option value="receiver_name" {{ request()->orderBy == 'receiver_name' ? 'selected' : '' }}>Penerima</option>
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
            @forelse ($delivery_orders as $deliveryOrder)
                <div class="card">
                    <div class="card-header">
                        <div class="flex flex-wrap justify-center md:justify-between items-center">
                            <div class="w-full md:w-auto text-center md:text-left">
                                <h4 class="font-bold mb-0">{{ $deliveryOrder->receiver_name ?? 'Data tidak tersedia' }}</h4>
                                <p class="mb-0">{{ $deliveryOrder->invoice_number }}</p>
                            </div>
                            <div class="text-center flex flex-col-reverse items-center md:block md:text-right">
                                <p class="text-sm text-gray-500">Nomor PO</p>
                                <p class="mb-0">{{ $deliveryOrder->purchaseOrder->invoice_number }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="w-full">
                            <tbody>
                                @foreach ($deliveryOrder->deliveryOrderItems as $deliveryOrderItem)
                                    <tr>
                                        <td class="font-medium">{{ $deliveryOrderItem->product->name ?? 'Data tidak tersedia' }}</td>
                                        <td class="text-right">{{ number_format($deliveryOrderItem->qty, 0, ',', '.') }} {{ $deliveryOrderItem->product->unit ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="flex flex-col md:grid md:grid-cols-2 md:items-center">
                            <div class="flex items-center space-x-3 justify-end md:justify-start">
                                <a href="{{ route('dashboard.delivery-order.invoice', $deliveryOrder->id) }}" class="btn btn-text" target="_blank">
                                    <i class="fas fa-print"></i>
                                    <span> Print </span>
                                </a>
                                @if(in_array($deliveryOrder->purchaseOrder->status ?? '', ['menunggu', 'diproses']))
                                    @can('delivery-orders.update')
                                        <a href="{{ route('dashboard.delivery-order.edit', $deliveryOrder->id) }}" class="btn btn-text">
                                            <i class="fas fa-pencil"></i>
                                            <span> Edit </span>
                                        </a>
                                    @endcan
                                    @can('delivery-orders.delete')
                                        <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.delivery-order.destroy', $deliveryOrder->id) }}">
                                            <i class="fas fa-trash"></i>
                                            <span> Hapus </span>
                                        </button>
                                    @endcan
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-xs">Diperbarui pada <span class="text-primary-600">{{ $deliveryOrder->updated_at->format('Y-m-d H:i') }}</span> oleh <span class="text-primary-600">{{ $deliveryOrder->user->name }}</span></p>
                        </div>
                    </div>
                </div>
            @empty
                @include('components.empty-state.card')
            @endforelse
            {{ $delivery_orders->links() }}
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
                            <h5 class="text-lg text-black font-medium">Tambah Surat Jalan</h5>
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
