<?php

namespace App\Repositories\Role;

use LaravelEasyRepository\Repository;

interface RoleRepository extends Repository{

    // Write something awesome :)

    public function exceptSuperadmin();

    public function withRelations(array $relations);

    public function orderData(string $order, string $direction);

    public function searchByName(string $name);
}
