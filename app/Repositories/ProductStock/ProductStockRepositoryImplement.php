<?php

namespace App\Repositories\ProductStock;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\ProductStock;
use DB;

class ProductStockRepositoryImplement extends Eloquent implements ProductStockRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ProductStock $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function getLatestProductStockFromEveryProductByDate(array $productIds, string $date)
    {
        $productStocks = $this->model->select('product_id', 'date', 'stock', 'delivery_order', 'procurement', 'sale', 'return', 'change', DB::raw('MAX(date) as latest_date'));

        if (count($productIds) > 0) $productStocks = $productStocks->whereIn('product_id', $productIds);

        return $productStocks->where('date', '<=', $date)
            ->groupBy(['product_id', 'date'])
            ->get();
    }

    public function getProductStockFromEveryProductByDates(array $productIds, array $dates)
    {
        $productStocks = $this->model;

        if (count($productIds) > 0) $productStocks = $productStocks->whereIn('product_id', $productIds);

        return $productStocks->whereIn('date', $dates)
            ->orderBy('date', 'desc')
            ->get();
    }
}
