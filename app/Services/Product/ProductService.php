<?php

namespace App\Services\Product;

use LaravelEasyRepository\BaseService;

interface ProductService extends BaseService{

    // Write something awesome :)

    public function getProductsWithCategoryName(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit);

    public function getAllProductsWithLatestStock(string $orderBy, string $orderType, ?array $filters, ?string $search, int $limit);
}
