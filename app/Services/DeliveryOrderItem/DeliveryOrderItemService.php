<?php

namespace App\Services\DeliveryOrderItem;

use LaravelEasyRepository\BaseService;

interface DeliveryOrderItemService extends BaseService{

    // Write something awesome :)

    public function insertDeliveryOrderItems(array $items, int $deliveryOrderId);

    public function updateDeliveryOrderItems(array $items, int $deliveryOrderId);
}
