@extends('layouts.dashboard')

@section('title', 'Edit Penjualan')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.sale.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Penjualan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Penjualan</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.sale.update', $sale->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ request()->user()->id }}">
                <div class="flex flex-col md:grid  md:grid-cols-6 gap-4 mt-0">
                    <div class="col-span-2">
                        <label for="customer_phone_number" class="label-block">Nomor Telepon Customer</label>
                        <input type="text" name="customer[phone_number]" id="customer_phone_number" class="@error('customer.phone_number') is-invalid @enderror form-control" placeholder="" value="{{ old('customer.phone_number') ?? $sale->customer->phone_number }}" required>
                        @error('customer.phone_number')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="customer_name" class="label-block">Nama Customer</label>
                        <input type="text" name="customer[name]" id="customer_name" class="@error('customer.name') is-invalid @enderror form-control" placeholder="" value="{{ old('customer.name') ?? $sale->customer->name }}" required>
                        @error('customer.name')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="date" class="label-block">Tanggal</label>
                        <input type="date" name="date" id="date" class="@error('date') is-invalid @enderror form-control" placeholder="" value="{{ old('date') ?? $sale->date->format('Y-m-d') }}" required>
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
                        <div class="overflow-x-auto">
                            <table class="table table-on-form">
                                <thead class="text-gray-700">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
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
                                <tbody class="sale-body">
                                    <tr class="empty-row">
                                        <td colspan="5" class="text-center">
                                            @include('components.empty-state.table')
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-span-4">
                        <div class="flex flex-col md:grid md:grid-cols-2 gap-4">
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="cash" {{ (old('payment_method') ?? $sale->payment_method) == 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="transfer" {{ (old('payment_method') ?? $sale->payment_method) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                                <option value="qris" {{ (old('payment_method') ?? $sale->payment_method) == 'qris' ? 'selected' : '' }}>QRIS</option>
                            </select>
                            <input type="text" name="total_paid" id="total_paid" class="form-control text-left currency" placeholder="Total Bayar" value="{{ old('total_paid') ?? $sale->total_paid }}" required style="display: none">
                            <select name="bank_id" id="bank_id" class="form-control init-select2" placeholder="Pilih Bank" style="display: none">
                                <option></option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ (old('bank_id') ?? $sale->bank_id) == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-start-5 col-span-2 mt-0">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        Total
                                        <input type="hidden" name="total" value="{{ old('total') ?? $sale->total }}">
                                    </td>
                                    <td class="text-right text-primary-600 font-medium" id="total-text">Rp0</td>
                                </tr>
                                <tr class="only-has-change" style="display:none">
                                    <td>
                                        Total Bayar
                                    </td>
                                    <td class="text-right text-gray-900 font-medium" id="total-paid-text">Rp0</td>
                                </tr>
                                <tr class="only-has-change" style="display:none">
                                    <td>
                                        Kembalian
                                        <input type="hidden" name="total_change" id="total_change" value="{{ old('total_change') ?? $sale->total_change }}">
                                    </td>
                                    <td class="text-right text-red-600 font-medium" id="total-change-text">Rp0</td>
                                </tr>
                            </tbody>
                        </table>
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
        let targetUrl = baseUrl + '/dashboard/sale';
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

            $(document).on('click', '.btn-delete', function()
            {
                $(this).closest('tr').remove();
                recalculateTotal();
                reorder();
            });

            $(document).on('keyup', 'input[name*="[qty]"]', function()
            {
                recalculateSellingPriceTotalByQty(this);
            });

            $(document).on('keyup', 'input[name*="[selling_price]"]', function()
            {
                recalculateSellingPriceTotal(this);
            });

            $(document).on('keyup', 'input[name*="[selling_price_total]"]', function()
            {
                recalculateSellingPriceBySellingPriceTotal(this);
            });

            $(document).on('keyup', '#total_paid', function()
            {
                recalculateChange();
            });

            $(document).on('change', '#payment_method', function()
            {
                recalculateChange();
            });

            initAutoComplete();
            recalculateChange();
            markActiveMenu(targetUrl);
        });

        function reorder()
        {
            isEmpty = true;
            $('.sale-items').each(function(index)
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

        function searchProductByCode(code)
        {
            let [product] = products.filter(product => product.product_code == code || product.barcode == code);

            return product;
        }

        function recalculateSellingPriceBySellingPriceTotal(selector)
        {
            let sellingPriceTotal = $(selector).val().replaceAll('.', '');
            let qty = $(selector).closest('.sale-items').find('input[name*="[qty]"]').val().replaceAll('.', '');
            let sellingPrice = sellingPriceTotal / qty;

            $(selector).closest('.sale-items').find('input[name*="[selling_price]"]').val(sellingPrice);

            recalculateTotal();
        }

        function recalculateSellingPriceTotal(selector)
        {
            let sellingPrice = $(selector).val().replaceAll('.', '');
            let qty = $(selector).closest('.sale-items').find('input[name*="[qty]"]').val().replaceAll('.', '');
            let sellingPriceTotal = sellingPrice * qty;

            $(selector).closest('.sale-items').find('input[name*="[selling_price_total]"]').val(sellingPriceTotal);

            recalculateTotal();
        }

        function recalculateSellingPriceTotalByQty(selector)
        {
            let qty = $(selector).val().replaceAll('.', '');
            let sellingPrice = $(selector).closest('.sale-items').find('input[name*="[selling_price]"]').val().replaceAll('.', '');
            let sellingPriceTotal = sellingPrice * qty;

            $(selector).closest('.sale-items').find('input[name*="[selling_price_total]"]').val(sellingPriceTotal);

            recalculateTotal();
        }

        function recalculateTotal()
        {
            let total = 0;

            $('.sale-items').each(function()
            {
                let qty = $(this).find('input[name*="[qty]"]').val().replaceAll('.', '');
                let sellingPrice = $(this).find('input[name*="[selling_price]"]').val().replaceAll('.', '');
                let sellingPriceTotal = $(this).find('input[name*="[selling_price_total]"]').val().replaceAll('.', '');
                console.log({qty, sellingPrice, sellingPriceTotal});

                total += parseInt(sellingPriceTotal);
            });

            $('input[name="total"]').val(total);

            $('#total-text').text('Rp' + formatRupiah(total));

            recalculateChange();
        }

        function recalculateChange()
        {
            let totalPaid;
            let change;

            let paymentMethod = $('#payment_method').find(':selected').val();
            let total = $('input[name="total"]').val().replaceAll('.', '');

            if (paymentMethod == 'cash')
            {
                $('#bank_id').prop('required', false)
                $('#bank_id').val('').trigger('change');
                $('#bank_id').next(".select2-container").hide();

                $('#total_paid').show();
            }else{
                $('#bank_id').prop('required', true)
                $('#bank_id').next(".select2-container").show();

                $('#total_paid').val(total);
                $('#total_paid').hide();
            }

            totalPaid = $('#total_paid').val().replaceAll('.', '');
            change = totalPaid - total;

            $('#total_change').val(change);

            $('#total-paid-text').text('Rp' + formatRupiah(totalPaid));
            $('#total-change-text').text('Rp' + formatRupiah(change));

            if(change > 0) {
                $('.only-has-change').show()
            }else{
                $('.only-has-change').hide()
            }

            if(!isEmpty)
            {
                if (totalPaid >= total) {
                    $('#btn-create').prop('disabled', false)
                }else{
                    $('#btn-create').prop('disabled', true)
                }

                $('.empty-row').hide();
            }else{
                $('#btn-create').prop('disabled', true);

                $('.empty-row').show();
            }
        }

        function addProductToTable(code)
        {
            let product = searchProductByCode(code);
            if (!product) {
                return false;
            }

            let existingRow = $(`.sale-items[data-product-code="${product.product_code}"]`);
            if (existingRow.length > 0) {
                let qty = existingRow.find('input[name*="[qty]"]');
                qty.val(parseInt(qty.val()) + 1);
                qty.trigger('keyup');
            }else{
                let htmlRow = `
                    <tr class="sale-items" data-product-code="${product.product_code}">
                        <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                            ${product.name} / ${product.unit}
                            <input type="hidden" name="sale_items[index][product_id]" value="${product.id}">
                        </th>
                        <td>${product?.latest_product_stock?.stock ?? 0}</td>
                        <td>
                            <input type="text" name="sale_items[index][qty]" class="form-control currency" value="1" required>
                        </td>
                        <td>
                            <input type="text" name="sale_items[index][selling_price]" class="form-control currency" value="${product.selling_price}" required>
                        </td>
                        <td>
                            <input type="text" name="sale_items[index][selling_price_total]" class="form-control currency" value="${product.selling_price}" required>
                        </td>
                        <td style="width: 1%">
                            <button type="button" class="btn btn-text btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('.sale-body').append(htmlRow);

                $(document).find(`.sale-items[data-product-code="${product.product_code}"]`).find('input[name*="[qty]"]').trigger('keyup')

                initInputmask();
                reorder();
            }

            recalculateTotal();
            return true;
        }

        function initAutoComplete()
        {
            let customers = @json($customers);

            let customerPhoneNumbers = customers.map(customer => customer.phone_number);
            let customerNames = customers.map(customer => customer.name);

            $('input[name="customer[phone_number]"]').autocomplete({
                source: customerPhoneNumbers,
                select: function(event, ui) {
                    let [customer] = customers.filter(customer => customer.phone_number == ui.item.value);
                    $('input[name="customer[name]"]').val(customer.name);
                },
                minLength: 5
            });

            $('input[name="customer[name]"]').autocomplete({
                source: customerNames,
                minLength: 2
            });

            $('#product_code').autocomplete({
                source: products.map(product => product.product_code)
            });
        }
    </script>

    @foreach (old('sale_items') ?? $sale->saleItems as $saleItem)
        <script>
            [oldProduct] = products.filter(product => product.id == @json($saleItem['product_id']));
            addProductToTable(oldProduct.product_code);

            $(document).ready(function() {
                var oldQty = @json($saleItem['qty']);
                $(document).find('tr[data-product-code="' + oldProduct.product_code + '"]').find('input[name*="[qty]"]').val(oldQty);
            });
        </script>
    @endforeach
@endpush
