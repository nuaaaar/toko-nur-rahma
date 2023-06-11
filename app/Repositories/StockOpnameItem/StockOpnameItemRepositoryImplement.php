<?php

namespace App\Repositories\StockOpnameItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\StockOpnameItem;

class StockOpnameItemRepositoryImplement extends Eloquent implements StockOpnameItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(StockOpnameItem $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function deleteByStockOpnameId(int $stockOpnameId)
    {
        return $this->model->where('stock_opname_id', $stockOpnameId)->delete();
    }
}
