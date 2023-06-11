<?php

namespace App\Services\ProductStock;

use LaravelEasyRepository\BaseService;

interface ProductStockService extends BaseService{

    // Write something awesome :)

    public function upsertProductStocksFromEveryProductByDate(string $transactionType, ?string $oldStartDate, string $newStartDate, ?array $oldItems, ?array $newItems);

    public function getProductStocksBetweenDates(array $productIds, string $startDate, string $endDate, string $orderBy, string $orderType, ?array $filters, ?string $search);
}
