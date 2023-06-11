<?php

namespace App\Services\DeliveryOrder;

use LaravelEasyRepository\BaseService;

interface DeliveryOrderService extends BaseService{

    // Write something awesome :)

    public function getDeliveryOrders(string $orderBy, string $orderType, ?array $filters = [], ?string $search = null, ?int $limit = 10);

    public function findById(int $id);
}
