<?php

namespace App\Repositories\Customer;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Customer;

class CustomerRepositoryImplement extends Eloquent implements CustomerRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Customer $model)
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
                ->orWhere('phone_number', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        });

        return $this;
    }

    public function findByPhoneNumber(string $phoneNumber)
    {
        return $this->model->where('phone_number', $phoneNumber)->first();
    }
}
