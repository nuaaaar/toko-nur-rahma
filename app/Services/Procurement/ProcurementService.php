<?php

namespace App\Services\Procurement;

use LaravelEasyRepository\BaseService;

interface ProcurementService extends BaseService{

    // Write something awesome :)

    public function findById(int $id);

    public function getProcurementsWithSupplierAndItems(?string $orderBy = 'date', ?string $orderType = 'asc', ?array $filters = [], ?string $search = null, ?int $limit = 10);
}
