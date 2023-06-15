<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Supplier\CreateSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Services\Supplier\SupplierService;
use DB;
use Illuminate\Http\Request;
use Log;
use Throwable;

class SupplierController extends Controller
{
    protected $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;

        $this->middleware(['permission:suppliers.read'], ['only' => ['index']]);
        $this->middleware(['permission:suppliers.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:suppliers.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:suppliers.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['suppliers'] = $this->supplierService->getSuppliers($request->orderBy, $request->orderType, $request->search, 10);

        return view('dashboard.supplier.index', $data);
    }

    public function create()
    {
        return view('dashboard.supplier.create');
    }

    public function store(CreateSupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->supplierService->create($request->except('_token'));
            DB::commit();

            return redirect()->route('dashboard.supplier.index')->with('success', 'Berhasil menambah data'); // Redirect ke halaman agen
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['supplier'] = $this->supplierService->findOrFail($id);

        return view('dashboard.supplier.edit', $data);
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $supplier = $this->supplierService->findOrFail($id);

            $supplier->update($request->except('_token'));

            DB::commit();

            return redirect()->route('dashboard.supplier.index')->with('success', 'Berhasil mengubah data'); // Redirect ke halaman agen
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $this->supplierService->delete($id);
            DB::commit();

            return redirect()->route('dashboard.supplier.index')->with('success', 'Berhasil menghapus data'); // Redirect ke halaman agen
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
