<?php

namespace App\Services\Sale;

use LaravelEasyRepository\Service;
use App\Repositories\Sale\SaleRepository;
use DB;

class SaleServiceImplement extends Service implements SaleService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(SaleRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getSales(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10)
    {
        $query = $this->mainRepository->joinCustomer()->withRelations(['purchaseOrder', 'saleItems.product', 'customer', 'user', 'bank'])->filter($filters)->search($search)->orderData($orderBy, $orderType);

        return $limit > 0 ? $query->paginate($limit) : $query->get();
    }

    public function create($data)
    {
        $sale = $this->mainRepository->create($data);

        $invoiceNumber = $this->generateInvoiceNumber($data['date']);

        $sale->update([
            'invoice_number' => $invoiceNumber['invoice_number'],
            'invoice_incremental_number' => $invoiceNumber['invoice_incremental_number']
        ]);

        return $sale;
    }

    public function createFromPurchaseOrder($purchaseOrder, $paymentData)
    {
        $sale = $this->mainRepository->create([
            'date' => $purchaseOrder->date,
            'total' => $purchaseOrder->total,
            'payment_method' => $paymentData['payment_method'],
            'total_paid' => $paymentData['total_paid'],
            'total_change' => $paymentData['total_change'] ?? 0,
            'bank_id' => $paymentData['bank_id'],
            'user_id' => $purchaseOrder->user_id,
            'customer_id' => $purchaseOrder->customer_id,
            'purchase_order_id' => $purchaseOrder->id,
        ]);

        $invoiceNumber = $this->generateInvoiceNumber($purchaseOrder->date);

        $sale->update([
            'invoice_number' => $invoiceNumber['invoice_number'],
            'invoice_incremental_number' => $invoiceNumber['invoice_incremental_number']
        ]);

        return $sale;
    }

    public function update($id, $data)
    {
        $invoiceNumber = $this->generateInvoiceNumber($data['date']);

        $data['invoice_number'] = $invoiceNumber['invoice_number'];
        $data['invoice_incremental_number'] = $invoiceNumber['invoice_incremental_number'];

        $sale = $this->mainRepository->update($id, $data);

        return $sale;
    }

    public function findById(int $id)
    {
        return $this->mainRepository->withRelations(['saleItems.product', 'customer', 'user'])->find($id);
    }

    public function findByInvoiceNumber(string $invoiceNumber)
    {
        return $this->mainRepository->withRelations(['saleItems.product.latestProductStock', 'customer', 'customerReturns', 'customerReturnItems.product', 'user'])->findByInvoiceNumber($invoiceNumber);
    }

    protected function generateInvoiceNumber(string $date)
    {
        $year = date('Y', strtotime($date));
        $formattedDate = date('Y/m/d', strtotime($date));

        $maxNumber = DB::table('sales')
            ->whereYear('date', $year)
            ->max('invoice_incremental_number');

        $invoiceNumber = ($maxNumber !== null) ? $maxNumber + 1 : 1;

        $formattedInvoiceNumber = "INV/$formattedDate/" . str_pad($invoiceNumber, 6, '0', STR_PAD_LEFT);

        return [
            'invoice_number' => $formattedInvoiceNumber,
            'invoice_incremental_number' => $invoiceNumber
        ];
    }
}
