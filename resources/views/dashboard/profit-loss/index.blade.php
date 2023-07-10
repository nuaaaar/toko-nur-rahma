@extends('layouts.dashboard')

@section('title', 'Laporan Stok')

@section('content')

    <div class="grid grid-cols-1 gap-4">
        <form class="">
            <div class="flex flex-col gap-4 md:flex-row items-center justify-end mt-4">
                <div class="w-full md:w-4/12">
                    <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                        <div class="w-full md:w-1/2">
                            <input type="date" name="filters[date_from]" class="form-control input-filter" value="{{ request()->filters['date_from'] ?? '' }}">
                        </div>
                        <div class="w-full md:w-1/2">
                            <input type="date" name="filters[date_to]"  class="form-control input-filter" value="{{ request()->filters['date_to'] ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/12">
                    <button type="submit" class="btn btn-primary w-full">Filter</button>
                </div>
            </div>
        </form>

        <h5 class="font-semibold">Laba-Rugi</h5>
        <div class="profit-loss-cards-wrapper">
            <div class="card">
                <div class="card-body p-6">
                    <h3 class="text-xl font-semibold mb-4">Total Penjualan</h3>
                    <p class="text-2xl font-bold text-green-500">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-6">
                    <h3 class="text-xl font-semibold mb-4">Total Pengadaan Stok</h3>
                    <p class="text-2xl font-bold {{ $procurements->sum('total') > 0 ? 'text-red-600' : '' }}">Rp{{ number_format($procurements->sum('total'), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-6">
                    <h3 class="text-xl font-semibold mb-4">Total Retur Customer</h3>
                    <p class="text-2xl font-bold {{ $customer_returns->sum('total') > 0 ? 'text-red-600' : '' }}">Rp{{ number_format($customer_returns->sum('total'), 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-6">
                    <h3 class="text-xl font-semibold mb-4">Total Laba-Rugi</h3>
                    <p class="text-2xl font-bold {{ $total_profit_loss > 0 ? 'text-green-500' : ($total_profit_loss < 0 ? 'text-red-600' : '')  }}">Rp{{ number_format($total_profit_loss, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <h5 class="font-semibold">Riwayat Penjualan</h5>
        <div class="card">
            <div class="card-header">
                <div class="overflow-auto" style="{{ count($sales) > 6 ? 'height: 250px' : '' }}">
                    <table class="table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-2/5">No. Invoice</th>
                                <th scope="col">Customer</th>
                                <th class="text-right" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody data-accordion="collapse">
                            @forelse ($sales as $sale)
                                <tr>
                                    <th class="cursor-pointer hover:bg-gray-100 font-medium text-gray-900 whitespace-nowrap dark:text-white"  data-accordion-target="#accordion-sale-{{ $sale->id }}" aria-controls="accordion-sale-{{ $sale->id }}" aria-expanded="false">
                                        <div class="flex justify-between w-full">
                                            <span>{{ $sale->invoice_number }}</span>
                                            <span>
                                                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                    </th>
                                    <td class="whitespace-nowrap">{{ $sale->customer->name ?? '' }}</td>
                                    <td class="font-medium text-black text-right">Rp{{ number_format($sale->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr id="accordion-sale-{{ $sale->id }}" class="hidden">
                                    <td>
                                        @foreach ($sale->saleItems as $saleItem)
                                            <div class="flex flex-col whitespace-nowrap">
                                                <span class="text-sm font-medium text-black">{{ $saleItem->product->name }} / {{ $saleItem->product->unit }}</span>
                                                <div class="flex gap-3 justify-between">
                                                    <span class="">x{{ $saleItem->qty }}</span>
                                                    <span class="text-right">Rp{{ number_format($saleItem->selling_price_total, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr class="border-0">
                                    <td colspan="3" class="text-center">
                                        @include('components.empty-state.table')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (count($sales) > 0)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="font-bold text-green-500 text-right">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <h5 class="font-semibold">Riwayat Pengadaan Stok</h5>
        <div class="card">
            <div class="card-header">
                <div class="overflow-auto" style="{{ count($procurements) > 6 ? 'height: 250px' : '' }}">
                    <table class="table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-2/5">No. Invoice</th>
                                <th scope="col">Agen</th>
                                <th class="text-right" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody data-accordion="collapse">
                            @forelse ($procurements as $procurement)
                                <tr>
                                    <th class="cursor-pointer hover:bg-gray-100 font-medium text-gray-900 whitespace-nowrap dark:text-white"  data-accordion-target="#accordion-procurement-{{ $procurement->id }}" aria-controls="accordion-procurement-{{ $procurement->id }}" aria-expanded="false">
                                        <div class="flex justify-between w-full">
                                            <span>{{ $procurement->invoice_number }}</span>
                                            <span>
                                                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                    </th>
                                    <td class="whitespace-nowrap">{{ $procurement->supplier->name ?? '' }}</td>
                                    <td class="font-medium text-black text-right">Rp{{ number_format($procurement->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr id="accordion-procurement-{{ $procurement->id }}" class="hidden">
                                    <td>
                                        @foreach ($procurement->procurementItems as $procurementItem)
                                            <div class="flex flex-col whitespace-nowrap">
                                                <span class="text-sm font-medium text-black">{{ $procurementItem->product->name }} / {{ $procurementItem->product->unit }}</span>
                                                <div class="flex gap-3 justify-between">
                                                    <span class="">x{{ $procurementItem->qty }}</span>
                                                    <span class="text-right">Rp{{ number_format($procurementItem->capital_price_total, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr class="border-0">
                                    <td colspan="3" class="text-center">
                                        @include('components.empty-state.table')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (count($procurements) > 0)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="font-bold {{ $procurements->sum('total') > 0 ? 'text-red-600' : '' }} text-right">Rp{{ number_format($procurements->sum('total'), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <h5 class="font-semibold">Riwayat Retur Customer</h5>
        <div class="card">
            <div class="card-header">
                <div class="overflow-auto" style="{{ count($customer_returns) > 6 ? 'height: 250px' : '' }}">
                    <table class="table">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="w-2/5">No. Invoice</th>
                                <th scope="col">Customer</th>
                                <th class="text-right" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody data-accordion="collapse">
                            @forelse ($customer_returns as $customerReturn)
                                <tr>
                                    <th class="cursor-pointer hover:bg-gray-100 font-medium text-gray-900 whitespace-nowrap dark:text-white"  data-accordion-target="#accordion-return-{{ $customerReturn->id }}" aria-controls="accordion-return-{{ $customerReturn->id }}" aria-expanded="false">
                                        <div class="flex justify-between w-full">
                                            <span>{{ $customerReturn->invoice_number }}</span>
                                            <span>
                                                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                    </th>
                                    <td class="whitespace-nowrap">{{ $customerReturn->sale->customer->name ?? '' }}</td>
                                    <td class="font-medium text-black text-right">Rp{{ number_format($customerReturn->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr id="accordion-return-{{ $customerReturn->id }}" class="hidden">
                                    <td>
                                        @foreach ($customerReturn->customerReturnItems as $customerReturnItem)
                                            <div class="flex flex-col whitespace-nowrap">
                                                <span class="text-sm font-medium text-black">{{ $customerReturnItem->product->name }} / {{ $customerReturnItem->product->unit }}</span>
                                                <div class="flex gap-3 justify-between">
                                                    <span class="">x{{ $customerReturnItem->qty }}</span>
                                                    <span class="text-right">Rp{{ number_format($customerReturnItem->selling_price_total, 0, ',', '.') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @empty
                                <tr class="border-0">
                                    <td colspan="3" class="text-center">
                                        @include('components.empty-state.table')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if (count($customer_returns) > 0)
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="font-bold {{ $customer_returns->sum('total') > 0 ? 'text-red-600' : '' }} text-right">Rp{{ number_format($customer_returns->sum('total'), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('script')
    <script>
    </script>
@endpush
