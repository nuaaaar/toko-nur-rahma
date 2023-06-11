<?php

namespace App\Services\Sale;

use LaravelEasyRepository\BaseService;

interface SaleService extends BaseService{

    // Write something awesome :)

    public function findById(int $id);

    public function findByInvoiceNumber(string $invoiceNumber);

    public function getSales(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10);

    public function createFromPurchaseOrder(array $purchaseOrder, array $paymentData);
}
