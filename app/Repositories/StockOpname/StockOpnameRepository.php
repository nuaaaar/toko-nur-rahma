<?php

namespace App\Repositories\StockOpname;

use LaravelEasyRepository\Repository;

interface StockOpnameRepository extends Repository{

    // Write something awesome :)

    public function withRelations(array $relations);

    public function filter(?array $filters = []);

    public function search(string $search = null);

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'desc');
}
