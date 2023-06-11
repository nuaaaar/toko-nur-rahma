<?php

namespace App\Repositories\PurchaseOrder;

use LaravelEasyRepository\Repository;

interface PurchaseOrderRepository extends Repository{

    // Write something awesome :)

    public function findByInvoiceNumber(string $invoiceNumber);

    public function joinCustomer();

    public function withRelations(array $relations);

    public function filter(?array $filters = []);

    public function search(?string $search = null);

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'asc');
}
