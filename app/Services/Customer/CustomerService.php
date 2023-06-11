<?php

namespace App\Services\Customer;

use LaravelEasyRepository\BaseService;

interface CustomerService extends BaseService{

    // Write something awesome :)

    public function getCustomers(string $orderBy, string $orderType, ?string $search, int $limit);

    public function updateOrCreateCustomer(array $data);
}
