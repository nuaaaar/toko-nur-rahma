@extends('layouts.dashboard')

@section('title', 'Edit Pengadaan Stok')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.procurement.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Pengadaan Stok</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Pengadaan Stok</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.procurement.update', $procurement->id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="user_id" value="{{ request()->user()->id }}">
                <div class="flex flex-col md:grid  md:grid-cols-6 gap-4 mt-0">
                    <div class="col-span-3">
                        <label for="supplier_id" class="label-block">Agen</label>
                        <div class="flex gap-1">
                            <div class="flex-grow">
                                <select name="supplier_id" id="supplier_id" class="form-control init-select2" placeholder="Pilih Agen" required>
                                    <option></option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ $supplier->id == (old('supplier_id') ?? $procurement->supplier_id) ? 'selected' : '' }}>{{ $supplier->tin . ' | ' . $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <a href="{{ route('dashboard.supplier.create') }}" class="btn btn-primary !h-full">
                                    <i class="fal fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        @error('supplier_id')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-1">
                        <label for="tax" class="label-block">Pajak %</label>
                        <input type="text" name="tax" id="tax" class="@error('tax') is-invalid @enderror form-control numeric !text-left" placeholder="" value="{{ old('tax') ?? $procurement->tax }}" maxlength="3" required>
                        @error('tax')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="date" class="label-block">Tanggal</label>
                        <input type="date" name="date" id="date" class="@error('date') is-invalid @enderror form-control" placeholder="" value="{{ old('date') ?? $procurement->date }}" required>
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
                                        <option value="{{ $product->id }}" data-product-code="{{ $product->product_code }}">{{ implode(' | ', [$product->product_code, $product->barcode ?? ' - ', $product->name . ' / ' . $product->unit]) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <table class="table table-on-form">
                            <thead class="text-gray-700">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th class="md:w-1/12">
                                        <div class="ml-auto text-right w-16">Qty</div>
                                    </th>
                                    <th class="md:w-1/6">
                                        <div class="ml-auto text-right w-32">Harga Satuan(Rp)</div>
                                    </th>
                                    <th class="md:w-1/6">
                                        <div class="ml-auto text-right w-32">Harga Total(Rp)</div>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="procurement-body">
                                <tr class="empty-row">
                                    <td colspan="5" class="text-center">
                                        @include('components.empty-state.table')
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-start-5 col-span-2">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        Subtotal
                                        <input type="hidden" name="subtotal" value="0">
                                    </td>
                                    <td class="text-right text-gray-900 font-medium" id="subtotal-text">Rp0</td>
                                </tr>
                                <tr>
                                    <td id="tax-label-text">
                                        Pajak (0%)
                                    </td>
                                    <td class="text-right text-gray-900 font-medium" id="tax-text">Rp0</td>
                                </tr>
                                <tr>
                                    <td>
                                        Total
                                        <input type="hidden" name="total" value="0">
                                    </td>
                                    <td class="text-right text-primary-600 font-medium" id="total-text">Rp0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary" id="btn-edit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let oldProduct;
        let products = @json($products);
        let targetUrl = baseUrl + '/dashboard/procurement';

        $(document).ready(function()
        {
            $(document).on('keydown', '.scanner', function(e)
            {
                if (e.keyCode == 13)
                {
                    e.preventDefault();
                    if (!addProductToTable($(this).val()))
                    {
                        showErrorDialog('Produk tidak ditemukan');
                    }else{
                        $(this).val('');
                        $(this).focus();
                    }
                    $(this).autocomplete('close');
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

            $(document).on('keyup', 'input[name="tax"]', function()
            {
                recalculateTotal();
            });

            $(document).on('keyup', 'input[name*="[qty]"]', function()
            {
                recalculateCapitalPriceTotalByQty(this);
            });

            $(document).on('keyup', 'input[name*="[capital_price]"]', function()
            {
                recalculateCapitalPriceTotal(this);
            });

            $(document).on('keyup', 'input[name*="[capital_price_total]"]', function()
            {
                recalculateCapitalPriceByCapitalPriceTotal(this);
            });

            $(document).on('click', '.btn-delete', function()
            {
                $(this).closest('.procurement-items').remove();
                recalculateTotal();
                reorder();
            });

            reorder();
            recalculateTotal();
            markActiveMenu(targetUrl);
        });

        function reorder()
        {
            let canSubmit = false;
            $('.procurement-items').each(function(index)
            {
                $(this).find('input').each(function()
                {
                    var name = $(this).attr('name');
                    var newName = name.replaceAll('index', index);

                    $(this).attr('name', newName);
                });

                canSubmit = true;
            });

            $('.procurement-items').each(function(index)
            {
                $(this).find('input').each(function()
                {
                    var name = $(this).attr('name');
                    var newName = name.replaceAll('index', index);

                    $(this).attr('name', newName);
                });
            });

            if (canSubmit)
            {
                $('#btn-edit').prop('disabled', false);
                $('.empty-row').hide();
            }else{
                $('#btn-edit').prop('disabled', true);
                $('.empty-row').show();
            }
        }

        function searchProductByCode(code)
        {
            let [product] = products.filter(product => product.product_code == code || product.barcode == code);

            return product;
        }

        function recalculateCapitalPriceByCapitalPriceTotal(selector)
        {
            let capitalPriceTotal = $(selector).val().replaceAll('.', '');
            let qty = $(selector).closest('.procurement-items').find('input[name*="[qty]"]').val().replaceAll('.', '');
            let capitalPrice = capitalPriceTotal / qty;

            $(selector).closest('.procurement-items').find('input[name*="[capital_price]"]').val(capitalPrice);

            recalculateTotal();
        }

        function recalculateCapitalPriceTotal(selector)
        {
            let capitalPrice = $(selector).val().replaceAll('.', '');
            let qty = $(selector).closest('.procurement-items').find('input[name*="[qty]"]').val().replaceAll('.', '');
            let capitalPriceTotal = capitalPrice * qty;

            $(selector).closest('.procurement-items').find('input[name*="[capital_price_total]"]').val(capitalPriceTotal);

            recalculateTotal();
        }

        function recalculateCapitalPriceTotalByQty(selector)
        {
            let qty = $(selector).val().replaceAll('.', '');
            let capitalPrice = $(selector).closest('.procurement-items').find('input[name*="[capital_price]"]').val().replaceAll('.', '');
            let capitalPriceTotal = capitalPrice * qty;

            $(selector).closest('.procurement-items').find('input[name*="[capital_price_total]"]').val(capitalPriceTotal);

            recalculateTotal();
        }

        function recalculateTotal()
        {
            let subtotal = 0;
            let tax = $('input[name="tax"]').val();
            let total = 0;

            $('.procurement-items').each(function()
            {
                let qty = $(this).find('input[name*="[qty]"]').val().replaceAll('.', '');
                let capitalPrice = $(this).find('input[name*="[capital_price]"]').val().replaceAll('.', '');
                let capitalPriceTotal = $(this).find('input[name*="[capital_price_total]"]').val().replaceAll('.', '');
                console.log({qty, capitalPrice, capitalPriceTotal});

                subtotal += parseInt(capitalPriceTotal);
            });

            total = subtotal + (subtotal * (tax / 100));

            $('input[name="subtotal"]').val(subtotal);
            $('input[name="total"]').val(total);


            $('#subtotal-text').text('Rp' + formatRupiah(subtotal));
            $('#tax-text').text('Rp' + formatRupiah(subtotal * (tax / 100)));
            $('#total-text').text('Rp' + formatRupiah(total));

            $('#tax-label-text').text('Pajak (' + tax + '%)');
        }

        function addProductToTable(code)
        {
            let product = searchProductByCode(code);
            if (!product) {
                return false;
            }

            let existingRow = $(`.procurement-items[data-product-code="${product.product_code}"]`);
            if (existingRow.length > 0) {
                let qty = existingRow.find('input[name*="[qty]"]');
                qty.val(parseInt(qty.val()) + 1);
                qty.trigger('keyup');
            }else{
                let htmlRow = `
                    <tr class="procurement-items" data-product-code="${product.product_code}">
                        <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                            ${product.name}
                            <input type="hidden" name="procurement_items[index][product_id]" value="${product.id}">
                        </th>
                        <td>
                            <input type="text" name="procurement_items[index][qty]" class="form-control currency" value="1" required>
                        </td>
                        <td>
                            <input type="text" name="procurement_items[index][capital_price]" class="form-control currency" value="${product.capital_price}" required>
                        </td>
                        <td>
                            <input type="text" name="procurement_items[index][capital_price_total]" class="form-control currency" value="${product.capital_price}" required>
                        </td>
                        <td style="width: 1%">
                            <button type="button" class="btn btn-text btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('.procurement-body').append(htmlRow);

                $(document).find(`.procurement-items[data-product-code="${product.product_code}"]`).find('input[name*="[qty]"]').trigger('keyup')

                initInputmask();
                reorder();
            }

            recalculateTotal();
            return true;
        }

        function initAutoComplete()
        {
            $('#product_code').autocomplete({
                source: products.map(product => product.product_code)
            });
        }
    </script>

    @foreach (old('procurement_items') ?? $procurement->procurementItems as $procurementItem)
        <script>
            [oldProduct] = products.filter(product => product.id == @json($procurementItem['product_id']));
            addProductToTable(oldProduct.product_code);
        </script>
    @endforeach
@endpush
