<?php

namespace App\Services\SaleItem;

use LaravelEasyRepository\BaseService;

interface SaleItemService extends BaseService{

    // Write something awesome :)

    public function insertSaleItems(array $items, int $saleId);

    public function updateSaleItems(array $items, int $saleId);
}
