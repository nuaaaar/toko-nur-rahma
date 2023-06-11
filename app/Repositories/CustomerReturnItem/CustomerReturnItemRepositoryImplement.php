<?php

namespace App\Repositories\CustomerReturnItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\CustomerReturnItem;

class CustomerReturnItemRepositoryImplement extends Eloquent implements CustomerReturnItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(CustomerReturnItem $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function deleteByCustomerReturnId(int $customerReturnId)
    {
        return $this->model->where('customer_return_id', $customerReturnId)->delete();
    }
}
