<?php

namespace App\Services\PurchaseOrder;

use LaravelEasyRepository\Service;
use App\Repositories\PurchaseOrder\PurchaseOrderRepository;
use DB;

class PurchaseOrderServiceImplement extends Service implements PurchaseOrderService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(PurchaseOrderRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getPurchaseOrders(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10)
    {
        $query =  $this->mainRepository->joinCustomer()->withRelations(['purchaseOrderItems.product', 'customer', 'user'])->filter($filters)->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function create($data)
    {
        $purchaseOrder = $this->mainRepository->create($data);

        $invoiceNumber = $this->generateInvoiceNumber($data['date']);

        $purchaseOrder->update([
            'invoice_number' => $invoiceNumber['invoice_number'],
            'invoice_incremental_number' => $invoiceNumber['invoice_incremental_number']
        ]);

        return $purchaseOrder;
    }

    public function update($id, $data)
    {
        $invoiceNumber = $this->generateInvoiceNumber($data['date']);

        $data['invoice_number'] = $invoiceNumber['invoice_number'];
        $data['invoice_incremental_number'] = $invoiceNumber['invoice_incremental_number'];

        $purchaseOrder = $this->mainRepository->update($id, $data);

        return $purchaseOrder;
    }

    public function changeStatus($id, $status)
    {
        $purchaseOrder = $this->mainRepository->update($id, [
            'status' => $status
        ]);

        return $purchaseOrder;
    }

    public function findById(int $id)
    {
        return $this->mainRepository->withRelations(['purchaseOrderItems.product', 'customer', 'user'])->find($id);
    }

    public function findByInvoiceNumber(string $invoiceNumber)
    {
        return $this->mainRepository->withRelations(['purchaseOrderItems.product.latestProductStock', 'customer', 'deliveryOrders', 'deliveryOrderItems.product', 'user'])->findByInvoiceNumber($invoiceNumber);
    }

    protected function generateInvoiceNumber(string $date)
    {
        $year = date('Y', strtotime($date));
        $formattedDate = date('Y/m/d', strtotime($date));

        $maxNumber = DB::table('purchase_orders')
            ->whereYear('date', $year)
            ->max('invoice_incremental_number');

        $invoiceNumber = ($maxNumber !== null) ? $maxNumber + 1 : 1;

        $formattedInvoiceNumber = "PO/$formattedDate/" . str_pad($invoiceNumber, 6, '0', STR_PAD_LEFT);

        return [
            'invoice_number' => $formattedInvoiceNumber,
            'invoice_incremental_number' => $invoiceNumber
        ];
    }
}
