<?php

namespace App\Repositories\Bank;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Bank;

class BankRepositoryImplement extends Eloquent implements BankRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function orderData(string $order, string $direction)
    {
        $this->model = $this->model->orderBy($order, $direction);

        return $this;
    }

    public function search(?string $search)
    {
        $this->model = $this->model->where(function($q) use ($search)
        {
            $q->where('name', 'like', "%$search%")
                ->orWhere('account', 'like', "%$search%")
                ->orWhere('account_name', 'like', "%$search%");
        });

        return $this;
    }
}
