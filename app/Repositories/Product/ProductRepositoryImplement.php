<?php

namespace App\Repositories\Product;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Product;

class ProductRepositoryImplement extends Eloquent implements ProductRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function withRelations(array $relations)
    {
        $this->model = $this->model->with($relations);
        return $this;
    }

    public function joinCategoryName()
    {
        $this->model = $this->model->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', 'categories.name as category_name');
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
                        if ($value != 'all') {
                            $q->orWhere($key, $value);
                        }
                    }
                });
            }
        }
        return $this;
    }

    public function search(?string $search)
    {
        if ($search != null) {
            $this->model = $this->model->where(function($q) use ($search)
            {
                $q->orWhere('products.name', 'like', "%$search%")
                    ->orWhere('product_code', 'like', "%$search%")
                    ->orWhere('categories.name', 'like', "%$search%")
                    ->orWhere('unit', 'like', "%$search%")
                    ->orWhere('capital_price', 'like', "%$search%")
                    ->orWhere('selling_price', 'like', "%$search%");
            });
        }
        return $this;
    }

    public function getProductWithProductStocksBetweenDates(array $productIds, string $startDate, string $endDate)
    {
        $this->model = $this->model->with(['productStocks' => function($q) use ($startDate, $endDate)
        {
            $q->where('date', '>=', $startDate)
                ->where('date', '<=', $endDate)
                ->orderBy('date', 'asc');
        }]);

        if (count($productIds) > 0) $this->model = $this->model->whereIn('id', $productIds);

        return $this;
    }
}
