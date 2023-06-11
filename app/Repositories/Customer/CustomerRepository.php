<?php

namespace App\Repositories\Customer;

use LaravelEasyRepository\Repository;

interface CustomerRepository extends Repository{

    // Write something awesome :)

    public function orderData(string $order, string $direction);

    public function search(?string $search);

    public function findByPhoneNumber(string $phoneNumber);
}
