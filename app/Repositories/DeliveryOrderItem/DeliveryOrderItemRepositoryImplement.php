<?php

namespace App\Repositories\DeliveryOrderItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\DeliveryOrderItem;

class DeliveryOrderItemRepositoryImplement extends Eloquent implements DeliveryOrderItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(DeliveryOrderItem $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function deleteByDeliveryOrderId(int $deliveryOrderId)
    {
        return $this->model->where('delivery_order_id', $deliveryOrderId)->delete();
    }
}
