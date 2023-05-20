<?php

namespace App\Services\Supplier;

use LaravelEasyRepository\BaseService;

interface SupplierService extends BaseService{

    // Write something awesome :)

    public function getSuppliers(string $orderBy, string $orderType, ?string $search, int $limit);
}
