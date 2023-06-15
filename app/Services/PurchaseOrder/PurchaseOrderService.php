<?php

namespace App\Services\PurchaseOrder;

use LaravelEasyRepository\BaseService;

interface PurchaseOrderService extends BaseService{

    // Write something awesome :)

    public function findById(int $id);

    public function findByInvoiceNumber(string $invoiceNumber);

    public function getPurchaseOrders(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10);

    public function changeStatus(int $id, string $status);

    public function getStatuses();
}
