<?php

namespace App\Services\CustomerReturnItem;

use LaravelEasyRepository\BaseService;

interface CustomerReturnItemService extends BaseService{

    // Write something awesome :)

    public function insertCustomerReturnItems(array $items, int $customerReturnId);

    public function updateCustomerReturnItems(array $items, int $customerReturnId);
}
