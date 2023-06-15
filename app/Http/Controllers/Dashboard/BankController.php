<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bank\CreateBankRequest;
use App\Http\Requests\Bank\UpdateBankRequest;
use App\Services\Bank\BankService;
use DB;
use Illuminate\Http\Request;
use Log;
use Throwable;

class BankController extends Controller
{
    protected $bankService;

    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;

        $this->middleware(['permission:banks.read'], ['only' => ['index']]);
        $this->middleware(['permission:banks.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:banks.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:banks.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'name'; // Atur default orderBy
        $request['orderType'] = $request->orderType ?? 'asc'; // Atur default orderType

        $data['banks'] = $this->bankService->getBanks($request->orderBy, $request->orderType, $request->search, 10);

        return view('dashboard.bank.index', $data);
    }

    public function create()
    {
        return view('dashboard.bank.create');
    }

    public function store(CreateBankRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->bankService->create($request->except('_token'));
            DB::commit();

            return redirect()->route('dashboard.bank.index')->with('success', 'Berhasil menambah data'); // Redirect ke halaman bank
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['bank'] = $this->bankService->findOrFail($id);

        return view('dashboard.bank.edit', $data);
    }

    public function update(UpdateBankRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $bank = $this->bankService->findOrFail($id);

            $bank->update($request->except('_token'));

            DB::commit();

            return redirect()->route('dashboard.bank.index')->with('success', 'Berhasil mengubah data'); // Redirect ke halaman bank
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $bank = $this->bankService->findOrFail($id);

            $bank->delete();

            DB::commit();

            return redirect()->route('dashboard.bank.index')->with('success', 'Berhasil menghapus data'); // Redirect ke halaman bank
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
