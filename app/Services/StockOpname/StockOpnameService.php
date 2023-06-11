<?php

namespace App\Services\StockOpname;

use LaravelEasyRepository\BaseService;

interface StockOpnameService extends BaseService{

    // Write something awesome :)

    public function getStockOpnames(string $orderBy, string $orderType, ?array $filters = [], ?string $search = null, ?int $limit = 10);

    public function findById(int $id);
}
