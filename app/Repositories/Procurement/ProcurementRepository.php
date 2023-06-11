<?php

namespace App\Repositories\Procurement;

use LaravelEasyRepository\Repository;

interface ProcurementRepository extends Repository{

    // Write something awesome :)

    public function joinSupplier();

    public function withRelations(array $relations);

    public function filter(?array $filters = []);

    public function search(?string $search = null);

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'asc');
}
