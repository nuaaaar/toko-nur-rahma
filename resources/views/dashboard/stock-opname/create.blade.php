@extends('layouts.dashboard')

@section('title', 'Tambah Stock Opname')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.stock-opname.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Stock Opname</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah Stock Opname</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.stock-opname.store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ request()->user()->id }}">
                <input type="hidden" name="date_from" value="{{ request()->date_from }}">
                <input type="hidden" name="date_to" value="{{ request()->date_to }}">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 mt-0">
                    <div class="col-span-full">
                        <h5>SO Periode: {{ request()->date_from }} s/d {{ request()->date_to }}</h5>
                    </div>
                    <div class="col-span-6">
                        <label for="title" class="label-block">Judul</label>
                        <input type="text" name="title" id="title" class="@error('title') is-invalid @enderror form-control" value="{{ old('title') ?? '' }}" required>
                        @error('title')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-6">
                        <label for="date" class="label-block">Tanggal SO</label>
                        <input type="date" name="date" id="date" class="@error('date') is-invalid @enderror form-control" placeholder="" value="{{ old('date') ?? date('Y-m-d') }}" min="{{ request()->date_to }}" required>
                        @error('date')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-full">
                        <label class="label-block">Barang</label>
                        <div class="flex flex-col md:grid  md:grid-cols-2 gap-4">
                            <div>
                                <input type="text" class="form-control scanner" id="product_code" placeholder="Cari berdasarkan kode barang atau scan barcode">
                            </div>
                            <div>
                                <select class="form-control init-select2" id="product_name" placeholder="Cari barang berdasarkan nama" allow-clear="true">
                                    <option></option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->product_id }}" data-product-code="{{ $product->product_code }}">{{ implode(' | ', [$product->product_code, $product->barcode ?? ' - ', $product->name . ' / ' . $product->unit]) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <div class="overflow-x-auto">
                            <table class="table table-on-form">
                                <thead class="text-gray-700">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th class="text-right">Fisik</th>
                                        <th class="text-right">Retur Supplier</th>
                                        <th class="text-right">Aktual</th>
                                        <th class="text-right">Sistem</th>
                                        <th class="text-right">Selisih</th>
                                        <th class="w-1/3">Keterangan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="stock-opname-body">
                                    <tr class="empty-row">
                                        <td colspan="7" class="text-center">
                                            @include('components.empty-state.table')
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
        let oldProduct;
        let products = @json($products);
        let targetUrl = baseUrl + '/dashboard/stock-opname';
        let isEmpty = true;

        $(document).ready(function()
        {
            $(document).on('keydown', '.scanner', function(e)
            {
                if (e.keyCode == 13)
                {
                    e.preventDefault();
                    if (!addProductToTable($(this).val()))
                    {
                        showErrorDialog('Produk tidak ditemukan pada invoice purchase order');
                    }else{
                        $(this).val('');
                        $(this).focus();
                    }
                    $(this).autocomplete('close');
                }
            });

            $(document).on('change', '.trigger-qty-actual', function()
            {
                recalculateActual();
            });

            $(document).on('change', '#product_name', function()
            {
                let productCode = $(this).find(':selected').data('product-code');
                if (productCode)
                {
                    $(this).val('').trigger('change');
                    addProductToTable(productCode);
                }
            });

            $(document).on('change', '#product_name', function()
            {
                let productCode = $(this).find(':selected').data('product-code');
                if (productCode)
                {
                    $(this).val('').trigger('change');
                    addProductToTable(productCode);
                }
            });

            $(document).on('click', '.btn-delete', function()
            {
                $(this).closest('tr').remove();
                reorder();
            });

            initAutoComplete();
            markActiveMenu(targetUrl);
        });

        function reorder()
        {
            isEmpty = true;
            $('.stock-opname-items').each(function(index)
            {
                $(this).find('input').each(function()
                {
                    var name = $(this).attr('name');
                    var newName = name.replaceAll('index', index);

                    $(this).attr('name', newName);
                });

                isEmpty = false;
            });

            if (isEmpty)
            {
                $('.empty-row').show();
            }else{
                $('.empty-row').hide();
            }
        }

        function recalculateActual()
        {
            $('.stock-opname-items').each(function()
            {
                let system = parseInt($(this).find('input[name*="[system]"]').val()) || 0;
                let physical = parseInt($(this).find('input[name*="[physical]"]').val()) || 0;
                let returnedToSupplier = parseInt($(this).find('input[name*="[returned_to_supplier]"]').val()) || 0;
                let actual = physical + returnedToSupplier;
                let difference = actual - system;

                $(this).find('.actual-text').text(number_format(actual, 0, ',', '.'));
                $(this).find('.difference-text').text(number_format(difference, 0, ',', '.'));

                difference != 0 ? $(this).find('.difference-text').addClass('text-red-500') : $(this).find('.difference-text').removeClass('text-red-500');
            });
        }

        function searchProductByCode(code)
        {
            let [product] = products.filter(product => product.product_code == code);

            return product;
        }

        function addProductToTable(code)
        {
            let product = searchProductByCode(code);
            if (!product) {
                return false;
            }

            let lastStock = product.filled_product_stocks[product.filled_product_stocks.length - 1];
            let existingRow = $(`.stock-opname-items[data-product-code="${product.product_code}"]`);
            if (existingRow.length > 0) {
                let qty = existingRow.find('input[name*="[qty]"]');
                qty.val((parseInt(qty.val()) || 0) + 1);
                qty.trigger('keyup');
            }else{
                let htmlRow = `
                    <tr class="stock-opname-items" data-product-code="${product.product_code}">
                        <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                            ${product.name} / ${product.unit}
                            <input type="hidden" name="stock_opname_items[index][product_id]" value="${product.id}">
                        </th>
                        <td>
                            <input type="text" class="form-control currency text-right trigger-qty-actual" name="stock_opname_items[index][physical]" style="min-width: 100px" value="" required>
                        </td>
                        <td>
                            <input type="text" class="form-control currency text-right trigger-qty-actual" name="stock_opname_items[index][returned_to_supplier]" style="min-width: 100px" value="" required>
                        </td>
                        <td class="text-right actual-text">0</td>
                        <td class="text-right">
                            ${lastStock.stock}
                            <input type="hidden" name="stock_opname_items[index][system]" value="${lastStock.stock}">
                        </td>
                        <td class="text-right difference-text">
                            ${0 - lastStock.stock}
                        </td>
                        <td>
                            <input type="text" class="form-control" name="stock_opname_items[index][description]" value="">
                        </td>
                        <td style="width: 1%">
                            <button type="button" class="btn btn-text btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('.stock-opname-body').append(htmlRow);

                $(document).find(`.stock-opname-items[data-product-code="${product.product_code}"]`).find('input[name*="[qty]"]').trigger('keyup')

                initInputmask();
                reorder();
            }

            return true;
        }

        function initAutoComplete()
        {
            $('#product_code').autocomplete({
                source: products.map(product => product.product_code)
            });
        }
    </script>

    @foreach (old('stock_opname_items') ?? [] as $stockOpnameItem)
        <script>
            [oldProduct] = products.filter(product => product.id == @json($stockOpnameItem['product_id']));
            addProductToTable(oldProduct.product_code);
        </script>
    @endforeach
@endpush
