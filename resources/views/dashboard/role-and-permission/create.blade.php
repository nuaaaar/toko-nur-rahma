@extends('layouts.dashboard')

@section('title', 'Tambah Jenis Pengguna')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.role-and-permission.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Jenis Pengguna</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah Jenis Pengguna</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.role-and-permission.store') }}" method="POST">
                @csrf
                <div class="mt-0">
                    <label for="name" class="label-block">Jenis Pengguna</label>
                    <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror form-control" placeholder="" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div>
                    <label class="label-block">Hak Akses</label>
                    @error('permissions')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="flex flex-wrap space-x-5">
                        @foreach ($groupedPermissions as $prefix => $permissions)
                            <div class="flex flex-col">
                                <h5 class="font-semibold">{{ __('modules.' . $prefix) }}</h5>
                                @foreach ($permissions as $key => $permission)
                                    <div class="flex item-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="permissions[]" id="{{ $prefix . '-' . $key }}" aria-describedby="{{ $prefix . '-' . $key }}" class="custom-checkbox permission-checkbox" value="{{ $prefix . '.' . $permission }}">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="{{ $prefix . '-' . $key }}" class="text-gray-500 dark:text-gray-300">{{ __('permissions.' . $permission) }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary" id="btn-create" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('js/pages/dashboard/role-and-permission/create.js') }}"></script>
@endpush
