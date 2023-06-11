<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Repository;

interface ProductRepository extends Repository{

    // Write something awesome :)
    public function withRelations(array $relations);

    public function joinCategoryName();

    public function orderData(string $order, string $direction);

    public function filter(?array $filters);

    public function search(?string $search);

    public function getProductWithProductStocksBetweenDates(array $productIds, string $startDate, string $endDate);
}
