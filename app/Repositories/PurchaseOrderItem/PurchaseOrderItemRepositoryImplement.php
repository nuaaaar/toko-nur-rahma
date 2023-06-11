<?php

namespace App\Repositories\PurchaseOrderItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\PurchaseOrderItem;

class PurchaseOrderItemRepositoryImplement extends Eloquent implements PurchaseOrderItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(PurchaseOrderItem $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function deleteByPurchaseOrderId(int $purchaseOrderId)
    {
        $this->model->where('purchase_order_id', $purchaseOrderId)->delete();
    }
}
