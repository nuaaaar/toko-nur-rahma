<?php

namespace App\Repositories\DeliveryOrder;

use LaravelEasyRepository\Repository;

interface DeliveryOrderRepository extends Repository{

    // Write something awesome :)

    public function withRelations(array $relations);

    public function filter(?array $filters = []);

    public function search(string $search = null);

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'desc');
}
