<?php

namespace App\Services\PurchaseOrderItem;

use LaravelEasyRepository\BaseService;

interface PurchaseOrderItemService extends BaseService{

    // Write something awesome :)

    public function insertPurchaseOrderItems(array $items, int $purchaseOrderId);

    public function updatePurchaseOrderItems(array $items, int $purchaseOrderId);
}
