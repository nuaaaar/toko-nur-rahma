@extends('layouts.dashboard')

@section('title', 'Edit Bank')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li>
                <div class="flex items-center">
                    <a href="{{ route('dashboard.bank.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Bank</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg aria-hidden="true" class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Edit Bank</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <form class="form" action="{{ route('dashboard.bank.update', $bank->id) }}" method="POST">
                @csrf
                @method("PUT")
                <div class="flex flex-col md:grid  md:grid-cols-3 gap-4 mt-0">
                    <div>
                        <label for="name" class="label-block">Nama Bank</label>
                        <input type="text" name="name" id="name" class="@error('name') is-invalid @enderror form-control" placeholder="" value="{{ old('name') ?? $bank->name }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="account" class="label-block">No. Rekening</label>
                        <input type="text" name="account" id="account" class="@error('account') is-invalid @enderror form-control" placeholder="" value="{{ old('account') ?? $bank->account }}" required>
                        @error('account')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label for="account-name" class="label-block">Atas Nama</label>
                        <input type="text" name="account_name" id="account-name" class="@error('account_name') is-invalid @enderror form-control" placeholder="" value="{{ old('account_name') ?? $bank->account_name }}">
                        @error('account_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary" id="btn-edit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function ()
        {
            let targetUrl = baseUrl + '/dashboard/bank';
            markActiveMenu(targetUrl);
        });
    </script>
@endpush
