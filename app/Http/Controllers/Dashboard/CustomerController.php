<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\Customer\CustomerService;
use DB;
use Illuminate\Http\Request;
use Log;
use Throwable;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

        $this->middleware(['permission:customers.read'], ['only' => ['index']]);
        $this->middleware(['permission:customers.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:customers.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:customers.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['customers'] = $this->customerService->getCustomers($request->orderBy, $request->orderType, $request->search, 10);

        return view('dashboard.customer.index', $data);
    }

    public function create()
    {
        return view('dashboard.customer.create');
    }

    public function store(CreateCustomerRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->customerService->create($request->except('_token'));
            DB::commit();

            return redirect()->route('dashboard.customer.index')->with('success', 'Berhasil menambah data'); // Redirect ke halaman agen
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['customer'] = $this->customerService->findOrFail($id);

        return view('dashboard.customer.edit', $data);
    }

    public function update(UpdateCustomerRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $customer = $this->customerService->findOrFail($id);

            $customer->update($request->except('_token'));

            DB::commit();

            return redirect()->route('dashboard.customer.index')->with('success', 'Berhasil mengubah data'); // Redirect ke halaman agen
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
            $this->customerService->delete($id);
            DB::commit();

            return redirect()->route('dashboard.customer.index')->with('success', 'Berhasil menghapus data'); // Redirect ke halaman agen
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
