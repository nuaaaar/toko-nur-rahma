<?php

namespace App\Repositories\DeliveryOrder;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\DeliveryOrder;

class DeliveryOrderRepositoryImplement extends Eloquent implements DeliveryOrderRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(DeliveryOrder $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function withRelations(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function filter(?array $filters = [])
    {
        $this->model = $this->model->where(function($query) use ($filters) {
            if (isset($filters['customer_id'])) {
                $query->whereHas('purchaseOrder', function($subquery) use ($filters)
                {
                    $subquery->where('customer_id', $filters['customer_id']);
                });
            }

            if (isset($filters['date_from'])) {
                $query->where('date', '>=', $filters['date_from']);
            }

            if (isset($filters['date_to'])) {
                $query->where('date', '<=', $filters['date_to']);
            }
        });

        return $this;
    }

    public function search(string $search = null)
    {
        if ($search) {
            $this->model = $this->model->where(function ($query) use ($search) {
                    $query->where('invoice_number', 'like', "%{$search}%")
                    ->orWhere('receiver_name', 'like', "%{$search}%")
                    ->orWhere('receiver_phone_number', 'like', "%{$search}%")
                    ->orWhere('receiver_address', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhereHas('purchaseOrder', function ($query) use ($search) {
                        $query->where('invoice_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('deliveryOrderItems.product', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $this;
    }

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'desc')
    {
        $this->model = $this->model->orderBy($orderBy, $orderType)->orderBy('id', $orderType);

        return $this;
    }
}
