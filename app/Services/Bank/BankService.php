<?php

namespace App\Services\Bank;

use LaravelEasyRepository\BaseService;

interface BankService extends BaseService{

    // Write something awesome :)

    public function getBanks(string $orderBy, string $orderType, ?string $search, int $limit);
}
