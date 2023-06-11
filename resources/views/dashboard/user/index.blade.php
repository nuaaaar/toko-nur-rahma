@extends('layouts.dashboard')

@section('title', 'Pengguna')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Pengguna</span>
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
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <i class="fa fa-filter w-4 h-4 mr-2"></i>
                            Filter
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown"
                            class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                            <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                Role
                            </h6>
                            <ul class="space-y-2 text-sm" aria-labelledby="dropdownDefault">
                                @foreach ($roles->where('name', '!=', 'Superadmin') as $key => $role)
                                    <li class="flex items-center">
                                        <input id="checkbox-role-{{ $key }}" type="checkbox" name="filters[roles.name][]" value="{{ $role->name }}"
                                            class="custom-checkbox" {{ in_array($role->name, request()->filters['roles.name'] ?? []) ? 'checked' : '' }} />
                                        <label for="checkbox-role-{{ $key }}"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $role->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                            <button class="btn btn-sm btn-primary w-full mt-2">Terapkan</button>
                        </div>
                        @can('users.create')
                            <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                <span> Pengguna </span>
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
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'role_name', 'orderType' => request()->orderBy == 'role_name' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Jenis Pengguna
                                    <i class="fa {{ request()->orderBy != 'role_name' ? 'fa-sort' : (request()->orderBy == 'role_name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'email', 'orderType' => request()->orderBy == 'email' && request()->orderType == 'asc' ? 'desc' : 'asc']) }}" class="inline-flex items-center gap-x-1">
                                    Email
                                    <i class="fa {{ request()->orderBy != 'email' ? 'fa-sort' : (request()->orderBy == 'email' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $user->name }}
                                </th>
                                <td>{{ $user->role_name ?? '' }}</td>
                                <td>{{ $user->email }}</td>
                                <td style="width: 1%">
                                    <div class="flex items-center justify-end space-x-3">
                                        @can('users.update')
                                            <a href="{{ route('dashboard.user.edit', $user->id) }}" class="btn btn-text">
                                                <i class="fas fa-pencil"></i>
                                                <span> Edit </span>
                                            </a>
                                        @endcan
                                        @can('users.delete')
                                            <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.user.destroy', $user->id) }}">
                                                <i class="fas fa-trash"></i>
                                                <span> Hapus </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-0">
                                <td colspan="4" class="text-center">
                                    @include('components.empty-state.table')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.user.destroy', ['user' => 0]) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function ()
        {
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
        });
    </script>
@endpush
