<?php

namespace App\Repositories\DeliveryOrderItem;

use LaravelEasyRepository\Repository;

interface DeliveryOrderItemRepository extends Repository{

    // Write something awesome :)

    public function deleteByDeliveryOrderId(int $deliveryOrderId);
}
