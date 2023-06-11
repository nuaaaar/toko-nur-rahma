<?php

namespace App\Repositories\CustomerReturnItem;

use LaravelEasyRepository\Repository;

interface CustomerReturnItemRepository extends Repository{

    // Write something awesome :)

    public function deleteByCustomerReturnId(int $customerReturnId);
}
