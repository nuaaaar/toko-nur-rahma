<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Repository;

interface UserRepository extends Repository{

    // Write something awesome :)
    public function findByEmail(string $email);

    public function withRelations(array $relations);

    public function joinRoleName();

    public function exceptSuperadmin();

    public function orderData(string $order, string $direction);

    public function filter(?array $filters);

    public function search(?string $search);
}
