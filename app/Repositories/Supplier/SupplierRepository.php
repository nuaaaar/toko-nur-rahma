<?php

namespace App\Repositories\Supplier;

use LaravelEasyRepository\Repository;

interface SupplierRepository extends Repository{

    // Write something awesome :)

    public function orderData(string $order, string $direction);

    public function search(?string $search);
}
