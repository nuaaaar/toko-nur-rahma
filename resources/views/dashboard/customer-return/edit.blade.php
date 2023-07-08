@extends('layouts.dashboard')

@section('title', 'Edit Retur Customer')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.customer-return.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Retur Customer</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Retur Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.customer-return.update', $customer_return->id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="sale_id" value="{{ $sale->id }}">
                <input type="hidden" name="customer_id" value="{{ $sale->customer_id }}">
                <input type="hidden" name="user_id" value="{{ request()->user()->id }}">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 mt-0">
                    <div class="col-span-4">
                        <label for="sale_invoice_number" class="label-block">Nomor Invoice Penjualan</label>
                        <input type="text" id="sale_invoice_number" class="form-control" value="{{ $sale->invoice_number ?? '' }}" disabled>
                    </div>
                    <div class="col-span-4">
                        <label for="customer_phone_number" class="label-block">Nomor Telepon Customer</label>
                        <input type="text" id="customer_phone_number" class="form-control" value="{{ $sale->customer->phone_number ?? '' }}" disabled>
                    </div>
                    <div class="col-span-4">
                        <label for="customer_name" class="label-block">Nama Customer</label>
                        <input type="text" id="customer_name" class="form-control" value="{{ $sale->customer->name ?? '' }}" disabled>
                    </div>
                    <div class="col-span-6">
                        <label for="category" class="label-block">Kategori</label>
                        <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" {{ old('category') ?? $customer_return->category == $category ? 'selected' : '' }}>{{ strtoupper($category) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-6">
                        <label for="date" class="label-block">Tanggal Retur</label>
                        <input type="date" name="date" id="date" class="@error('date') is-invalid @enderror form-control" placeholder="" value="{{ old('date') ?? $customer_return->date->format('Y-m-d') }}" min="{{ $sale->date->format('Y-m-d') }}" required>
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
                                    @foreach ($sale->saleItems as $saleItem)
                                        <option value="{{ $saleItem->product_id }}" data-product-code="{{ $saleItem->product->product_code }}">{{ implode(' | ', [$saleItem->product->product_code, $saleItem->product->barcode ?? ' - ', $saleItem->product->name . ' / ' . $saleItem->product->unit]) }}</option>
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
                                        <th>Dapat Dikembalikan</th>
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
                                        <td colspan="7" class="text-center">
                                            @include('components.empty-state.table')
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-start-9 col-span-4 mt-0">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td>
                                        Total
                                        <input type="hidden" name="total" value="0">
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
                                        <input type="hidden" name="total_change" id="total_change">
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
        let customerReturnId = @json($customer_return->id);
        let saleItems = @json($sale->saleItems ?? []);
        let products = saleItems.flatMap(saleItem => saleItem.product);
        let customerReturnItems = @json($customer_return->customerReturnItems ?? []);
        let otherCustomerReturnItems = customerReturnItems.filter(customerReturnItem => customerReturnItem.customer_return_id != customerReturnId);
        let targetUrl = baseUrl + '/dashboard/customer-return';
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
                        showErrorDialog('Produk pada invoice penjualan');
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


            initAutoComplete();
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
            let [product] = products.filter(product => product.product_code == code);

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

                total += parseInt(sellingPriceTotal);
            });

            $('input[name="total"]').val(total);

            $('#total-text').text('Rp' + formatRupiah(total));
        }


        function addProductToTable(code)
        {
            let product = searchProductByCode(code);
            if (!product) {
                return false;
            }
            let saleItem = saleItems.find(saleItem => saleItem.product.product_code == code || saleItem.product.barcode == code);
            let otherReturnedItems = otherCustomerReturnItems.filter(customerReturnItem => customerReturnItem.product.product_code == code || customerReturnItem.product.barcode == code);
            let totalReturnedQty = otherReturnedItems.reduce((total, customerReturnItem) => total + customerReturnItem.qty, 0);
            let currentCustomerReturnItem = customerReturnItems.find(customerReturnItem => customerReturnItem.product.product_code == code || customerReturnItem.product.barcode == code  && customerReturnItem.customer_return_id == customerReturnId);

            let existingRow = $(`.sale-items[data-product-code="${product.product_code}"]`);
            if (existingRow.length > 0) {
                let qty = existingRow.find('input[name*="[qty]"]');
                qty.val((parseInt(qty.val()) || 0) + 1);
                qty.trigger('keyup');
            }else{
                let htmlRow = `
                    <tr class="sale-items" data-product-code="${product.product_code}">
                        <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                            ${product.name} / ${product.unit}
                            <input type="hidden" name="customer_return_items[index][product_id]" value="${product.id}">
                        </th>
                        <td>${product?.latest_product_stock?.stock ?? 0}</td>
                        <td>${saleItem.qty - totalReturnedQty}</td>
                        <td>
                            <input type="text" name="customer_return_items[index][qty]" class="form-control currency" max="${saleItem.qty - totalReturnedQty}" value="${currentCustomerReturnItem.qty ?? 1}" required>
                        </td>
                        <td>
                            <input type="text" name="customer_return_items[index][selling_price]" class="form-control currency" value="${saleItem.selling_price}" required>
                        </td>
                        <td>
                            <input type="text" name="customer_return_items[index][selling_price_total]" class="form-control currency" value="${saleItem.selling_price}" required>
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
            $('#product_code').autocomplete({
                source: products.map(product => product.product_code)
            });
        }
    </script>

    @foreach (old('customer_return_items') ?? $customer_return->customerReturnItems as $customerReturnItem)
        <script>
            [oldProduct] = products.filter(product => product.id == @json($customerReturnItem['product_id']));
            addProductToTable(oldProduct.product_code);

            $(document).ready(function() {
                var oldQty = @json($customerReturnItem['qty']);
                $(document).find('tr[data-product-code="' + oldProduct.product_code + '"]').find('input[name*="[qty]"]').val(oldQty);
            });
        </script>
    @endforeach
@endpush
