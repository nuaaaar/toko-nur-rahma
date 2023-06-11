@extends('layouts.dashboard')

@section('title', 'Jenis Pengguna')

@section('content')

    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Jenis Pengguna</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                <div class="w-full md:w-3/4">
                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <i class="fal fa-search"></i>
                            </div>
                            <input type="text" name="search" id="simple-search" class="form-control" placeholder="Cari" value="{{ request()->search }}">
                        </div>
                    </form>
                </div>
                <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                    @can('roles.create')
                        <a href="{{ route('dashboard.role-and-permission.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            <span> Jenis Pengguna </span>
                        </a>
                    @endcan
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'name', 'orderType' => request()->orderBy == 'name' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center">
                                    Jenis Pengguna
                                    <i class="fa {{ request()->orderBy != 'name' ? 'fa-sort' : (request()->orderBy == 'name' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'users_count', 'orderType' => request()->orderBy == 'users_count' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center">
                                    Jumlah Pengguna
                                    <i class="fa {{ request()->orderBy != 'users_count' ? 'fa-sort' : (request()->orderBy == 'users_count' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <a href="{{ request()->fullUrlWithQuery(['orderBy' => 'permissions_count', 'orderType' => request()->orderBy == 'permissions_count' && request()->orderType == 'asc' ? 'desc' : 'asc' ]) }}" class="inline-flex items-center">
                                    Hak Akses
                                    <i class="fa {{ request()->orderBy != 'permissions_count' ? 'fa-sort' : (request()->orderBy == 'permissions_count' && request()->orderType == 'asc' ? 'fa-sort-up' : 'fa-sort-down')  }} w-3 h-3 ml-1"></i>
                                </a>
                            </th>
                            <th scope="col">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody data-accordion="collapse">
                        @forelse ($roles as $role)
                            <tr>
                                <th class="font-medium text-gray-900 whitespace-nowrap dark:text-white" >
                                    {{ $role->name }}
                                </th>
                                <td>{{ number_format(count($role->users), 0, ',', ',') }}</td>
                                <td class="cursor-pointer hover:bg-gray-100" data-accordion-target="#accordion-permissions-{{ $role->id }}" aria-controls="accordion-permissions-{{ $role->id }}" aria-expanded="false">
                                    <div class="flex justify-between w-full">
                                        <span>{{ number_format(count($role->permissions), 0, ',', ',') }} Akses</span>
                                        <span>
                                            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </span>
                                    </div>
                                </td>
                                <td style="width: 1%">
                                    <div class="flex items-center justify-end space-x-3">
                                        @can('roles.update')
                                            <a href="{{ route('dashboard.role-and-permission.edit', $role->id) }}" class="btn btn-text">
                                                <i class="fas fa-pencil"></i>
                                                <span> Edit </span>
                                            </a>
                                        @endcan
                                        @can('roles.delete')
                                            <button class="btn btn-text btn-delete" data-url="{{ route('dashboard.role-and-permission.destroy', $role->id) }}">
                                                <i class="fas fa-trash"></i>
                                                <span> Hapus </span>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            <tr id="accordion-permissions-{{ $role->id }}" class="hidden">
                                <td colspan="5">
                                    <div class="flex flex-wrap space-x-5">
                                        @foreach ($groupedPermissions as $prefix => $permissions)
                                            <div class="flex flex-col">
                                                <h5 class="font-semibold">{{ __('modules.' . $prefix) }}</h5>
                                                @php
                                                    $prefixPermissions = $role->permissions->where(function($permission) use ($prefix)
                                                        {
                                                            return \Str::startsWith($permission->name, $prefix . '.');
                                                        });
                                                @endphp
                                                @if (count($prefixPermissions) > 0)
                                                    <ul class="list-disc list-inside">
                                                        @foreach ($prefixPermissions as $permission)
                                                            <li>{{ __('permissions.' . explode('.', $permission->name)[1]) }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p>Tidak ada akses</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-0">
                                <td colspan="5" class="text-center">
                                    @include('components.empty-state.table')
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $roles->links() }}
        </div>
    </div>

    <form id="form-delete" action="{{ route('dashboard.role-and-permission.destroy', ['role_and_permission' => 0]) }}" method="POST" class="hidden">
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
