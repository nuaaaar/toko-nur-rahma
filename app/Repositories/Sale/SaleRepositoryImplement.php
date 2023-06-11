<?php

namespace App\Repositories\Sale;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Sale;

class SaleRepositoryImplement extends Eloquent implements SaleRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function findByInvoiceNumber(string $invoiceNumber)
    {
        return $this->model->where('invoice_number', $invoiceNumber)->first();
    }

    public function joinCustomer()
    {
        $this->model = $this->model->select('sales.*', 'customers.name as customer_name', 'customers.phone_number as customer_phone_number', 'customers.address as customer_address')
            ->join('customers', 'customers.id', '=', 'sales.customer_id');

        return $this;
    }

    public function withRelations(array $relations)
    {
        $this->model = $this->model->with($relations);

        return $this;
    }

    public function filter(?array $filters = [])
    {
        $this->model = $this->model->where(function($query) use ($filters) {
            if (isset($filters['customer_id'])) {
                $query->where('customer_id', $filters['customer_id']);
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
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhere('total', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%")
                    ->orWhereHas('purchaseOrder', function ($query) use ($search) {
                        $query->where('invoice_number', 'like', "%{$search}%");
                    })
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('saleItems.product', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('bank', function ($query) use ($search) {
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
