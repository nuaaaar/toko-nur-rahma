<?php

namespace App\Repositories\StockOpname;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\StockOpname;

class StockOpnameRepositoryImplement extends Eloquent implements StockOpnameRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(StockOpname $model)
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
                    $query->where('title', 'like', "%{$search}%")
                    ->orWhere('date_from', 'like', "%{$search}%")
                    ->orWhere('date_to', 'like', "%{$search}%")
                    ->orWhere('date', 'like', "%{$search}%")
                    ->orWhereHas('stockOpnameItems.product', function ($query) use ($search) {
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
