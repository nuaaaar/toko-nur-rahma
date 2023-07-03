<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Import\ProductImportRequest;
use App\Imports\Product\ProductImport;
use App\Models\Product;
use DB;
use Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductImportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:import-data.read'], ['only' => ['index']]);
        $this->middleware(['permission:import-data.create'], ['only' => ['store']]);
    }

    public function index()
    {
        return view('dashboard.product-import.index');
    }

    public function store(ProductImportRequest $request)
    {
        ini_set('memory_limit', '1024M');

        DB::beginTransaction();
        try{

            Excel::import(new ProductImport, $request->file('file'));

            DB::commit();

            return redirect()->route('dashboard.product.index')->with('success', 'Berhasil mengimport data');
        }catch(\Throwable $e){
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', 'Gagal mengimport data, pastikan format sudah sesuai');
        }
    }
}
