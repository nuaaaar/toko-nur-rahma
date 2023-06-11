<?php

namespace App\Services\CustomerReturn;

use LaravelEasyRepository\Service;
use App\Repositories\CustomerReturn\CustomerReturnRepository;
use DB;

class CustomerReturnServiceImplement extends Service implements CustomerReturnService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(CustomerReturnRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function getCategories()
    {
        return ['ganti barang', 'refund pembayaran'];
    }

    public function getCustomerReturns(string $orderBy, string $orderType, ?array $filters = [], ?string $search = null, ?int $limit = 10)
    {
        return $this->mainRepository->withRelations(['customer', 'customerReturnItems.product', 'sale'])->filter($filters)->search($search)->orderData($orderBy, $orderType)->paginate($limit);
    }

    public function findById($id)
    {
        return $this->mainRepository->withRelations(['customer', 'customerReturnItems.product', 'sale'])->find($id);
    }

    public function create($data)
    {
        $invoiceNumber = $this->generateInvoiceNumber($data['date']);
        $data['invoice_number'] = $invoiceNumber['invoice_number'];
        $data['invoice_incremental_number'] = $invoiceNumber['invoice_incremental_number'];

        return $this->mainRepository->create($data);
    }

    protected function generateInvoiceNumber(string $date)
    {
        $year = date('Y', strtotime($date));
        $formattedDate = date('Y/m/d', strtotime($date));

        $maxNumber = DB::table('customer_returns')
            ->whereYear('date', $year)
            ->max('invoice_incremental_number');

        $invoiceNumber = ($maxNumber !== null) ? $maxNumber + 1 : 1;

        $formattedInvoiceNumber = "CR/$formattedDate/" . str_pad($invoiceNumber, 6, '0', STR_PAD_LEFT);

        return [
            'invoice_number' => $formattedInvoiceNumber,
            'invoice_incremental_number' => $invoiceNumber
        ];
    }
}
