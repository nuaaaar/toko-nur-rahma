<?php

namespace App\Repositories\PurchaseOrderItem;

use LaravelEasyRepository\Repository;

interface PurchaseOrderItemRepository extends Repository{

    // Write something awesome :)

    public function deleteByPurchaseOrderId(int $purchaseOrderId);
}
