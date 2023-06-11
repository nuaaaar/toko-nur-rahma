@extends('layouts.dashboard')

@section('title', 'Tambah Customer')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.customer.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Customer</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tambah Customer</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.customer.update', $customer->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="flex flex-col md:grid  md:grid-cols-2 gap-4 mt-0">
                    <div>
                        <label for="name" class="label-block">Nama</label>
                        <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror form-control" placeholder="" value="{{ old('name') ?? $customer->name }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="phone-number" class="label-block">Nomor Telepon</label>
                        <input type="text" name="phone_number" id="phone-number" class="@error('phone_number') is-invalid @enderror form-control" placeholder="" value="{{ old('phone_number') ?? $customer->phone_number }}">
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-span-2">
                        <label for="address" class="label-block">Alamat</label>
                        <textarea name="address" id="address" class="@error('address') is-invalid @enderror form-control" rows="5" placeholder="">{{ old('address') ?? $customer->address }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
        $(document).ready(function ()
        {
            let targetUrl = baseUrl + '/dashboard/customer';
            markActiveMenu(targetUrl);
        });
    </script>
@endpush
