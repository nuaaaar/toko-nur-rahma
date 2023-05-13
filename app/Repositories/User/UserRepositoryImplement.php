<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository
{
    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function withRelations(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function joinRoleName()
    {
        $this->model = $this->model->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name');

        return $this;
    }

    public function exceptSuperadmin()
    {
        $this->model = $this->model->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Superadmin');
        });

        return $this;
    }

    public function orderData(string $order, string $direction)
    {
        $this->model = $this->model->orderBy($order, $direction);

        return $this;
    }

    public function filter(?array $filters)
    {
        if ($filters != null) {
            foreach ($filters as $key => $values) {
                $this->model = $this->model->where(function($q) use ($key, $values)
                {
                    foreach ($values as $value) {
                        $q->orWhere($key, $value);
                    }
                });
            }
        }

        return $this;
    }

    public function search(?string $search)
    {
        $this->model = $this->model->where(function($q) use ($search)
        {
            $q->where('users.name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('roles.name', 'like', "%$search%");
        });

        return $this;
    }
}
