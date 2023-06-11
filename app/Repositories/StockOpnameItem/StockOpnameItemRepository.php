<?php

namespace App\Repositories\StockOpnameItem;

use LaravelEasyRepository\Repository;

interface StockOpnameItemRepository extends Repository{

    // Write something awesome :)

    public function deleteByStockOpnameId(int $stockOpnameId);
}
