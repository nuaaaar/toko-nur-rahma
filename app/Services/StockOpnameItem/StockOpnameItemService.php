<?php

namespace App\Services\StockOpnameItem;

use LaravelEasyRepository\BaseService;

interface StockOpnameItemService extends BaseService{

    // Write something awesome :)

    public function insertStockOpnameItems(array $items, int $stockOpnameId);

    public function updateStockOpnameItems(array $items, int $Id);
}
