@extends('layouts.dashboard')

@section('title', 'Pencadangan Data')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Pencadangan Data</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Jenis Barang</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data produk akan mencadangkan data jenis barang.
                    </p>
                </div>
                <div class="flex justify-end">
                    <a href="{{ route('export.product') }}" class="btn btn-primary inline-flex items-center space-x-1">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pengadaan Stok</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data pengadaan stok akan mencadangkan data pengadaan stok.
                    </p>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary inline-flex items-center space-x-1 btn-export-transaction" data-title="Pengadaan Stok" data-url="{{ route('export.procurement') }}">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Penjualan</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data penjualan akan mencadangkan data penjualan.
                    </p>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary inline-flex items-center space-x-1 btn-export-transaction" data-title="Penjualan" data-url="{{ route('export.sale') }}">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Retur Customer</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data retur customer akan mencadangkan data retur customer.
                    </p>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary inline-flex items-center space-x-1 btn-export-transaction" data-title="Retur Customer" data-url="{{ route('export.customer-return') }}">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Purchase Order</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data purchase order akan mencadangkan data purchase order.
                    </p>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary inline-flex items-center space-x-1 btn-export-transaction" data-title="Purchase Order" data-url="{{ route('export.purchase-order') }}">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Stock Opname</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Pencadangan data stock opname akan mencadangkan data stock opname.
                    </p>
                </div>
                <div class="flex justify-end">
                    <button class="btn btn-primary inline-flex items-center space-x-1 btn-export-transaction" data-title="Stock Opname" data-url="{{ route('export.stock-opname') }}">
                        <i class="fas fa-download"></i>
                        <span>Unduh Data</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.btn-export-transaction', function()
            {
                let title = $(this).data('title');
                let url = $(this).data('url');
                showFormDialog(null, `
                    <form action="${url}">
                        <div class="mb-5">
                            <h5 class="text-xl text-black font-medium">${title}</h5>
                            <h5 class="text-base text-black font-medium">Pilih Periode Tanggal</h5>
                        </div>
                        <div class="mb-2">
                            <label class="label-block text-left">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ date('Y-m-01') }}" id="procurement-date-from" required>
                        </div>
                        <div>
                            <label class="label-block text-left">Hingga Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ date('Y-m-d') }}" id="procurement-date-to" required>
                        </div>
                        <button type="submit" id="btn-submit-procurement" style="display: none;"></button>
                    </form>
                `, () => {
                    $(document).find('#btn-submit-procurement').click();
                    if ($('#procurement-date-from').val() == '' || $('#procurement-date-to').val() == '') {
                        return false;
                    }
                })
            });
        });
    </script>
@endpush
