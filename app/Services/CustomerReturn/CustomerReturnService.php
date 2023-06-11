<?php

namespace App\Services\CustomerReturn;

use LaravelEasyRepository\BaseService;

interface CustomerReturnService extends BaseService{

    // Write something awesome :)

    public function getCategories();

    public function getCustomerReturns(string $orderBy, string $orderType, ?array $filters = [], ?string $search = null, ?int $limit = 10);

    public function findById(int $id);
}
