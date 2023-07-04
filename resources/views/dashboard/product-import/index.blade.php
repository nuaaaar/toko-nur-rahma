@extends('layouts.dashboard')

@section('title', 'Import Jenis Barang')

@section('content')
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Import Jenis Barang</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <div class="label-block">File yang didukung harus dengan format .xlsx, .xls</div>
                <a href="{{ url('storage/excel/product-example.xlsx') }}" class="btn btn-primary inline-flex">
                    <i class="fa fa-download mr-2"></i>
                    <span>Unduh Contoh File</span>
                </a>
                <form action="{{ route('dashboard.product-import.store') }}" method="POST" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="label-block">Pilih File</label>
                        <div class="flex gap-5">
                            <div class="grow-1 w-full">
                                <input type="file" name="file" accept=".xlsx, .xls" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-upload mr-2"></i>
                                    <span>Upload</span>
                                </button>
                            </div>
                        </div>
                        @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
                <div class="md:grid md:grid-cols-2 md:gap-4 mt-4 ">
                    <div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Kode Barang</td>
                                    <td class="text-red-500">Wajib Diisi</td>
                                </tr>
                                <tr>
                                    <td>Barcode</td>
                                    <td>Opsional</td>
                                </tr>
                                <tr>
                                    <td>Kode Barang</td>
                                    <td class="text-red-500">Wajib Diisi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>Satuan</td>
                                    <td class="text-red-500">Wajib Diisi</td>
                                </tr>
                                <tr>
                                    <td>Harga Modal</td>
                                    <td class="text-red-500">Wajib Diisi</td>
                                </tr>
                                <tr>
                                    <td>Harga Jual</td>
                                    <td class="text-red-500">Wajib Diisi</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function()
        {
            $(document).on('click', '.btn-export-transaction', function()
            {
                let title = $(this).data('title');
                let url = $(this).data('url');
                showFormDialog(null, `
                    <form action="${url}">
                        <div class="mb-5">
                            <h5 class="text-xl text-black font-medium">${title}</h5>
                            <h5 class="text-base text-black font-medium">Pilih Periode Tanggal</h5>
                        </div>
                        <div class="mb-2">
                            <label class="label-block text-left">Dari Tanggal</label>
                            <input type="date" name="date_from" class="form-control" value="{{ date('Y-m-01') }}" id="product-import-date-from" required>
                        </div>
                        <div>
                            <label class="label-block text-left">Hingga Tanggal</label>
                            <input type="date" name="date_to" class="form-control" value="{{ date('Y-m-d') }}" id="product-import-date-to" required>
                        </div>
                        <button type="submit" id="btn-submit-product-import" style="display: none;"></button>
                    </form>
                `, () => {
                    $(document).find('#btn-submit-product-import').click();
                    if ($(document).find('#product-import-date-from').val() == '' || $(document).find('#product-import-date-to').val() == '') {
                        return false;
                    }
                })
            });
        });
    </script>
@endpush
