<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Procurement\ProcurementService;
use Illuminate\Http\Request;

class ProcurementInvoiceController extends Controller
{
    protected $procurementService;

    public function __construct(ProcurementService $procurementService)
    {
        $this->procurementService = $procurementService;

        $this->middleware('permission:procurements.read');
    }

    public function __invoke($id)
    {
        return $this->invoice($id);
    }

    public function invoice($id)
    {
        $data['procurement'] = $this->procurementService->findById($id);

        return view('dashboard.procurement.invoice', $data);
    }
}
