@extends('layouts.dashboard')

@section('title', 'Customer')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-3/4">
                        <input type="hidden" name="orderBy" value="{{ request()->orderBy }}">
                        <input type="hidden" name="orderType" value="{{ request()->orderType }}">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="fal fa-search"></i>
                            </div>
                            <input type="text" name="search" id="simple-search" class="form-control" placeholder="Cari" value="{{ request()->search }}">
                        </div>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        @can('customers.create')
                            <a href="{{ route('dashboard.customer.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span> Customer </span>
                            </a>
                        @endcan
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'name', 'orderType' => request()->orderBy == 'name' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center gap-x-1">
                                    Nama
                                    <i class="fa {{ request()->orderBy != 'name' ? 'fa-sort' : (request()->orderBy == 'name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th class="whitespace-nowrap" scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'phone_number', 'orderType' => request()->orderBy == 'phone_number' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Nomor Telepon
                                    <i class="fa {{ request()->orderBy != 'phone_number' ? 'fa-sort' : (request()->orderBy == 'phone_number' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'address', 'orderType' => request()->orderBy == 'address' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Alamat
                                    <i class="fa {{ request()->orderBy != 'address' ? 'fa-sort' : (request()->orderBy == 'address' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $key => $customer)
                            <tr>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $customer->name }}
                                </th>
                                <td>{{ $customer->phone_number }}</td>
                                <td>
                                    <p class="line-clamp-1 max-w-prose" {{ strlen($customer->address) > 65 ? "data-tooltip-target=tooltip-address-$key" : '' }}>{{ $customer->address }}</p>
                                    @if (strlen($customer->address) > 65)
                                        <div id="tooltip-address-{{ $key }}" role="tooltip" class="absolute z-10 max-w-prose invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            {{ $customer->address }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endif
                                </td>
                                <td style="width: 1%">
                                    <div class="flex items-center justify-end space-x-3">
                                        @can('customers.update')
                                            <a href="{{ route('dashboard.customer.edit', $customer->id) }}" class="btn btn-text">
                                                <i class="fas fa-pencil"></i>
                                                <span> Edit </span>
                                            </a>
                                        @endcan
                                        @can('customers.delete')
                                            <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.customer.destroy', $customer->id) }}">
                                                <i class="fas fa-trash"></i>
                                                <span> Hapus </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-0">
                                <td colspan="4">
                                    @include('components.empty-state.table')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $customers->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.customer.destroy', ['customer' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script>
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
    </script>
@endpush
