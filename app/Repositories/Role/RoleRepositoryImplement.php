<?php

namespace App\Repositories\Role;

use DB;
use LaravelEasyRepository\Implementations\Eloquent;
use Spatie\Permission\Models\Role;

class RoleRepositoryImplement extends Eloquent implements RoleRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function withRelations(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function exceptSuperadmin()
    {
        $this->model = $this->model->where('name', '!=', 'superadmin');

        return $this;
    }

    public function orderData(string $order, string $direction)
    {
        $this->model = $this->model->withCount('users')->withCount('permissions')->orderBy($order, $direction);

        return $this;
    }

    public function searchByName(?string $name)
    {
        $this->model->where('name', 'like', "%$name%");

        return $this;
    }
}
