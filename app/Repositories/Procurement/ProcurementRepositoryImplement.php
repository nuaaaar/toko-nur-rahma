<?php

namespace App\Repositories\Procurement;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Procurement;

class ProcurementRepositoryImplement extends Eloquent implements ProcurementRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Procurement $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function joinSupplier()
    {
        $this->model = $this->model->select('procurements.*', 'suppliers.name as supplier_name', 'suppliers.phone_number as supplier_phone_number', 'suppliers.address as supplier_address')
            ->join('suppliers', 'suppliers.id', '=', 'procurements.supplier_id');

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
            if (isset($filters['supplier_id'])) {
                $query->where('supplier_id', $filters['supplier_id']);
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
                $query->where('suppliers.name', 'like', "%$search%")
                    ->orWhereHas('procurementItems.product', function ($query2) use ($search) {
                        $query2->where('name', 'like', "%$search%");
                    });
            });
        }

        return $this;
    }

    public function orderData(?string $orderBy = 'date', ?string $orderType = 'asc')
    {
        $this->model = $this->model->orderBy($orderBy, $orderType)->orderBy('id', $orderType);

        return $this;
    }
}
