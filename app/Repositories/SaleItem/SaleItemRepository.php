<?php

namespace App\Repositories\SaleItem;

use LaravelEasyRepository\Repository;

interface SaleItemRepository extends Repository{

    // Write something awesome :)

    public function deleteBySaleId(int $saleId);
}
