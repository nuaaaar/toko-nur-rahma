@extends('layouts.dashboard')

@section('title', 'Edit Surat Jalan')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.delivery-order.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Surat Jalan</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Surat Jalan</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.delivery-order.update', $delivery_order->id) }}" method="POST">
                @csrf
                @method("PUT")
                <input type="hidden" name="purchase_order_id" value="{{ $purchase_order->id }}">
                <input type="hidden" name="customer_id" value="{{ $purchase_order->customer_id }}">
                <input type="hidden" name="user_id" value="{{ request()->user()->id }}">
                <div class="flex flex-col md:grid md:grid-cols-12 gap-4 mt-0">
                    <div class="col-span-6">
                        <label for="purchase_order_invoice_number" class="label-block">Nomor Invoice Purchase Order</label>
                        <input type="text" id="purchase_order_invoice_number" class="form-control" value="{{ $purchase_order->invoice_number ?? '' }}" disabled>
                    </div>
                    <div class="col-span-6">
                        <label for="date" class="label-block">Tanggal Pengiriman</label>
                        <input type="date" name="date" id="date" class="@error('date') is-invalid @enderror form-control" placeholder="" value="{{ old('date') ?? $delivery_order->date }}" min="{{ $purchase_order->date }}" required>
                        @error('date')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-4">
                        <label for="receiver_phone_number" class="label-block">Nomor Telepon Penerima</label>
                        <input type="text" name="receiver_phone_number" id="receiver_phone_number" class="@error('receiver_phone_number') is-invalid @enderror form-control" placeholder="" value="{{ old('receiver_phone_number') ?? $delivery_order->receiver_phone_number }}"  required>
                        @error('receiver_phone_number')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-4">
                        <label for="receiver_name" class="label-block">Nama Penerima</label>
                        <input type="text" name="receiver_name" id="receiver_name" class="@error('receiver_name') is-invalid @enderror form-control" placeholder="" value="{{ old('receiver_name') ?? $delivery_order->receiver_name }}"  required>
                        @error('receiver_name')
                            <span class="invalid-feedback" category="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-4">
                        <label for="receiver_address" class="label-block">Alamat Penerima</label>
                        <input type="text" name="receiver_address" id="receiver_address" class="@error('receiver_address') is-invalid @enderror form-control" placeholder="" value="{{ old('receiver_address') ?? $delivery_order->receiver_address }}"  required>
                        @error('receiver_address')
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
                                    @foreach ($purchase_order->purchaseOrderItems as $purchaseOrderItem)
                                        <option value="{{ $purchaseOrderItem->product_id }}" data-product-code="{{ $purchaseOrderItem->product->product_code }}">{{ implode(' | ', [$purchaseOrderItem->product->product_code, $purchaseOrderItem->product->barcode ?? ' - ', $purchaseOrderItem->product->name . ' / ' . $purchaseOrderItem->product->unit]) }}</option>
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
                                        <th>Belum Dikirim</th>
                                        <th class="md:w-1/12">
                                            <div class="ml-auto text-right w-16">Qty</div>
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="purchase-order-body">
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
        let deliveryOrderId = @json($delivery_order->id);
        let purchaseOrderItems = @json($purchase_order->purchaseOrderItems ?? []);
        let products = purchaseOrderItems.flatMap(purchaseOrderItem => purchaseOrderItem.product);
        let deliveryOrderItems = @json($delivery_order->deliveryOrderItems ?? []);
        let otherDeliveryOrderItems = deliveryOrderItems.filter(deliveryOrderItem => deliveryOrderItem.delivery_order_id != deliveryOrderId);
        let targetUrl = baseUrl + '/dashboard/delivery-order';
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
            $('.purchase-order-items').each(function(index)
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

        function addProductToTable(code)
        {
            let product = searchProductByCode(code);
            if (!product) {
                return false;
            }
            let purchaseOrderItem = purchaseOrderItems.find(purchaseOrderItem => purchaseOrderItem.product.product_code == code || purchaseOrderItem.product.barcode == code);
            let otherReturnedItems = otherDeliveryOrderItems.filter(deliveryOrderItem => deliveryOrderItem.product.product_code == code || deliveryOrderItem.product.barcode == code);
            let totalReturnedQty = otherReturnedItems.reduce((total, deliveryOrderItem) => total + deliveryOrderItem.qty, 0);
            let currentDeliveryOrderItem = deliveryOrderItems.find(deliveryOrderItem => (deliveryOrderItem.product.product_code == code || deliveryOrderItem.product.barcode == code) && deliveryOrderItem.delivery_order_id == deliveryOrderId);

            let existingRow = $(`.purchase-order-items[data-product-code="${product.product_code}"]`);
            if (existingRow.length > 0) {
                let qty = existingRow.find('input[name*="[qty]"]');
                qty.val((parseInt(qty.val()) || 0) + 1);
                qty.trigger('keyup');
            }else{
                let htmlRow = `
                    <tr class="purchase-order-items" data-product-code="${product.product_code}">
                        <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                            ${product.name} / ${product.unit}
                            <input type="hidden" name="delivery_order_items[index][product_id]" value="${product.id}">
                        </th>
                        <td>${product?.latest_product_stock?.stock ?? 0}</td>
                        <td>${purchaseOrderItem.qty - totalReturnedQty}</td>
                        <td>
                            <input type="text" name="delivery_order_items[index][qty]" class="form-control currency" max="${purchaseOrderItem.qty - totalReturnedQty}" value="${currentDeliveryOrderItem.qty ?? 1}" required>
                        </td>
                        <td style="width: 1%">
                            <button type="button" class="btn btn-text btn-delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('.purchase-order-body').append(htmlRow);

                $(document).find(`.purchase-order-items[data-product-code="${product.product_code}"]`).find('input[name*="[qty]"]').trigger('keyup')

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

    @foreach (old('delivery_order_items') ?? $delivery_order->deliveryOrderItems as $deliveryOrderItem)
        <script>
            [oldProduct] = products.filter(product => product.id == @json($deliveryOrderItem['product_id']));
            addProductToTable(oldProduct.product_code);
        </script>
    @endforeach
@endpush
