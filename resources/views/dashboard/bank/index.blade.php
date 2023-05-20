@extends('layouts.dashboard')

@section('title', 'Bank')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Bank</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
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
                        <a href="{{ route('dashboard.bank.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span> Bank </span>
                        </a>
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'name', 'orderType' => request()->orderBy == 'name' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center gap-x-1">
                                    Nama Bank
                                    <i class="fa {{ request()->orderBy != 'name' ? 'fa-sort' : (request()->orderBy == 'name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'account', 'orderType' => request()->orderBy == 'account' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    No. Rekening
                                    <i class="fa {{ request()->orderBy != 'account' ? 'fa-sort' : (request()->orderBy == 'account' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th class="whitespace-nowrap" scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'account_name', 'orderType' => request()->orderBy == 'account_name' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Atas Nama
                                    <i class="fa {{ request()->orderBy != 'account_name' ? 'fa-sort' : (request()->orderBy == 'account_name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($banks as $key => $bank)
                            <tr>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $bank->name }}
                                </th>
                                <td>{{ $bank->account }}</td>
                                <td>{{ $bank->account_name }}</td>
                                <td style="width: 1%">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a href="{{ route('dashboard.bank.edit', $bank->id) }}" class="btn btn-text">
                                            <i class="fas fa-pencil"></i>
                                            <span> Edit </span>
                                        </a>
                                        <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.bank.destroy', $bank->id) }}">
                                            <i class="fas fa-trash"></i>
                                            <span> Delete </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $banks->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.bank.destroy', ['bank' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script src="{{ asset('js/pages/dashboard/bank/index.js') }}"></script>
@endpush
