<?php

namespace App\Repositories\Bank;

use LaravelEasyRepository\Repository;

interface BankRepository extends Repository{

    // Write something awesome :)

    public function orderData(string $order, string $direction);

    public function search(?string $search);
}
