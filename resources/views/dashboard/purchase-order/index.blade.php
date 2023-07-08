@extends('layouts.dashboard')

@section('title', 'Purchase Order')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Purchase Order</span>
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
                        <input type="hidden" name="filters[status]" id="filter-status" value="{{ request()->filters['status'] ?? '' }}">
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
                        @can('purchase-orders.create')
                            <a href="{{ route('dashboard.purchase-order.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span> Purchase Order </span>
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
                    <label class="block mb-2">Status</label>
                    <select class="form-control input-filter init-select2" placeholder="Pilih Status" data-filter-hidden="#filter-status" allow-clear="true">
                        <option></option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status}}" {{ request()->filters['status'] ?? '' == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
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
            @forelse ($purchase_orders as $purchaseOrder)
                <div class="card">
                    <div class="card-header">
                        <div class="flex flex-wrap justify-center md:justify-between items-center">
                            <div class="text-center w-full md:text-left md:w-auto">
                                <h4 class="font-bold mb-0">{{ $purchaseOrder->customer->name ?? 'Data tidak tersedia' }}</h4>
                                <p class="font-medium mb-0">{{ $purchaseOrder->customer->phone_number ?? 'Data tidak tersedia' }}</p>
                                <p class="font-medium mb-0">{{ $purchaseOrder->customer->address ?? 'Data tidak tersedia' }}</p>
                            </div>
                            <div class="text-center flex flex-col-reverse items-center md:flex-col md:items-end md:text-right">
                                @can('purchase-orders.change-status')
                                    @if ($purchaseOrder->status == 'diproses')
                                        <button type="button" class="btn btn-sm btn-success btn-done" data-invoice-number="{{ $purchaseOrder->invoice_number }}" data-total="{{ $purchaseOrder->total }}" data-url="{{ route('dashboard.purchase-order.change-status', $purchaseOrder->id) }}">
                                            <i class="fas fa-edit"></i>
                                            <span> Selesaikan </span>
                                            <div class="badge badge-primary uppercase text-sm">{{ $purchaseOrder->status }}</div>
                                        </button>
                                    @elseif ($purchaseOrder->status == 'menunggu')
                                        <button type="button" class="btn btn-sm btn-secondary btn-cancel" data-invoice-number="{{ $purchaseOrder->invoice_number }}" data-url="{{ route('dashboard.purchase-order.change-status', $purchaseOrder->id) }}">
                                            <i class="fas fa-edit"></i>
                                            <span> Batalkan </span>
                                            <div class="badge badge-danger uppercase text-sm">{{ $purchaseOrder->status }}</div>
                                        </button>
                                    @else
                                        <div class="badge {{ $purchaseOrder->status == 'dibatalkan' ? 'badge-secondary' : 'badge-success' }} uppercase text-sm">{{ $purchaseOrder->status }}</div>
                                        @if ($purchaseOrder->status == 'selesai' && $purchaseOrder->sale != null)
                                            @can('sales.read')
                                                <a href="{{ route('dashboard.sale.index', ['search' => $purchaseOrder->sale->invoice_number]) }}" class="block mb-0 hover:text-primary-600 md:order-last">{{ $purchaseOrder->sale->invoice_number }}</a>
                                            @else
                                                <p class="md:order-last mb-0">{{ $purchaseOrder->sale->invoice_number }}</p>
                                            @endcan
                                        @endif
                                    @endif
                                @else
                                    <div class="badge {{ $purchaseOrder->status == 'menunggu' ? 'badge-danger': ($purchaseOrder->status == 'diproses' ? 'badge-primary' : ($purchaseOrder->status == 'selesai' ? 'badge-success' : 'badge-secondary')) }} uppercase text-sm">{{ $purchaseOrder->status }}</div>
                                @endcan
                                <p class="mb-0 md:order-0">{{ $purchaseOrder->invoice_number }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="w-full">
                            <tbody>
                                @foreach ($purchaseOrder->purchaseOrderItems as $purchaseOrderItem)
                                    @php
                                        $totalDeliveredPurchaseOrderItem = $purchaseOrder->deliveryOrderItems->where('product_id', $purchaseOrderItem->product_id)->sum('qty');
                                        $totalPurchaseOrderItem = $purchaseOrderItem->qty;
                                        $totalToDeliverPurchaseOrderItem = $totalPurchaseOrderItem - $totalDeliveredPurchaseOrderItem;
                                    @endphp
                                    <tr>
                                        <td colspan="2" class="font-medium">{{ $purchaseOrderItem->product->name ?? 'Data tidak tersedia' }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="flex gap-2">
                                                <div>x{{ number_format($purchaseOrderItem->qty, 0, ',', '.') }}</div>
                                                @if ($purchaseOrder->status == 'diproses' && $totalToDeliverPurchaseOrderItem > 0)
                                                    <div>
                                                        (<span class="text-red-600 font-bold">{{ number_format($totalToDeliverPurchaseOrderItem, 0, ',', '.') }}</span> belum dikirim)
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-right">Rp{{ number_format($purchaseOrderItem->selling_price_total, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="flex flex-col md:grid  md:grid-cols-2 md:items-center">
                            <div class="flex items-center space-x-3 justify-end md:justify-start">
                                <a href="{{ route('dashboard.purchase-order.invoice', $purchaseOrder->id) }}" class="btn btn-text" target="_blank">
                                    <i class="fas fa-print"></i>
                                    <span> Print </span>
                                </a>
                                @if (in_array($purchaseOrder->status, ['menunggu', 'diproses']))
                                    @can('purchase-orders.update')
                                        <a href="{{ route('dashboard.purchase-order.edit', $purchaseOrder->id) }}" class="btn btn-text">
                                            <i class="fas fa-pencil"></i>
                                            <span> Edit </span>
                                        </a>
                                    @endcan
                                    @can('purchase-orders.delete')
                                        <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.purchase-order.destroy', $purchaseOrder->id) }}">
                                            <i class="fas fa-trash"></i>
                                            <span> Hapus </span>
                                        </button>
                                    @endcan
                                @endif
                            </div>
                            <div class="flex items-center justify-end space-x-4 order-first md:order-last">
                                <div class="flex space-x-1 text-xs text-gray-400 items-center">
                                    <span>Total</span>
                                    @if ($purchaseOrder->tax != null)
                                        <i class="fas fa-info-circle text-sm cursor-pointer" data-tooltip-target="tooltip-total-{{ $purchaseOrder->id }}"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-primary-600 text-lg">Rp{{ number_format($purchaseOrder->total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="mb-0 text-xs">Diperbarui pada <span class="text-primary-600">{{ $purchaseOrder->updated_at->format('Y-m-d H:i') }}</span> oleh <span class="text-primary-600">{{ $purchaseOrder->user->name }}</span></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold mb-0">Surat Jalan</h4>
                            </div>
                            @if (in_array($purchaseOrder->status, ['menunggu', 'diproses']))
                                <div>
                                    <a href="{{ route('dashboard.delivery-order.create', ['invoice_number' => $purchaseOrder->invoice_number]) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-plus"></i>
                                        <span> Surat Jalan </span>
                                    </a>
                                </div>
                            @endif
                        </div>
                        @foreach ($purchaseOrder->deliveryOrders as $deliveryOrder)
                            <a href="{{ route('dashboard.delivery-order.index', ['search' => $deliveryOrder->invoice_number]) }}" class="flex items-center gap-2 hover:text-primary-600" target="_blank">
                                <span>{{ $deliveryOrder->invoice_number }}</span>
                                <span><i class="fal fa-search text-xs"></i></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @empty
                @include('components.empty-state.card')
            @endforelse
            {{ $purchase_orders->appends(request()->except('page'))->links() }}
        </div>
    </div>

    <form id="form-change-status" action="{{ route('dashboard.purchase-order.change-status', ['purchase_order' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="">
    </form>

    <form id="form-delete" action="{{ route('dashboard.purchase-order.destroy', ['purchase_order' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function ()
        {
            $(document).on('click', '.btn-done', function ()
            {
                let url = $(this).data('url');
                let invoiceNumber = $(this).data('invoice-number');
                let total = $(this).data('total');

                showFormDialog(null, `
                <form id="form-done" action="${url}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <h5 class="text-base text-black font-medium">Selesaikan Purchase Order</h5>
                        <h5 class="text-lg text-black font-medium">${invoiceNumber}</h5>
                        <h5 class="text-lg text-primary-600 font-medium">Rp${number_format(total, 0, ',', '.')}</h5>
                    </div>
                    <input type="hidden" name="status" value="selesai">
                    <div class="mb-4">
                        <label for="payment_method" class="label-block text-left">Metode Pembayaran</label>
                        <select name="payment[payment_method]" id="payment_method" class="form-control" data-total="${total}" required>
                            <option value="transfer">Transfer</option>
                            <option value="qris">QRIS</option>
                        </select>
                    </div>
                    <div id="total-paid-wrapper" style="display:none">
                        <label for="total_paid" class="label-block text-left">Total Bayar</label>
                        <input type="text" name="payment[total_paid]" id="total_paid" class="form-control text-left currency" placeholder="Total Bayar" value="${total}" required>
                    </div>
                    <div id="bank-wrapper">
                        <label for="bank_id" class="label-block text-left">Bank</label>
                        <select name="payment[bank_id]" id="bank_id" class="form-control init-select2" placeholder="Pilih Bank">
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                `, () => {
                    $('#form-done').submit();
                });

            });

            $(document).on('change', '#payment_method', function ()
            {
                let value = $(this).find('option:selected').val();
                let total = $(this).data('total');
                if (value == 'tunai')
                {
                    $('#bank_id').prop('required', false)
                    $('#bank-wrapper').hide();
                }
                else
                {
                    $('#bank_id').prop('required', true)
                    $('#bank-wrapper').show();
                }
            });

            $(document).on('click', '.btn-cancel', function ()
            {
                let url = $(this).data('url');
                showConfirmDialog('Apakah anda yakin ingin membatalkan pesanan ini?', function ()
                {
                    let changeStatusForm = $('#form-change-status');
                    changeStatusForm.attr('action', url);
                    changeStatusForm.find('input[name="status"]').val('dibatalkan');
                    changeStatusForm.submit();
                });
            });

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
        });

    </script>
@endpush
