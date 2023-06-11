<?php

namespace App\Repositories\ProductStock;

use LaravelEasyRepository\Repository;

interface ProductStockRepository extends Repository{

    // Write something awesome :)

    public function getLatestProductStockFromEveryProductByDate(array $productIds, string $date);

    public function getProductStockFromEveryProductByDates(array $productIds, array $dates);
}
