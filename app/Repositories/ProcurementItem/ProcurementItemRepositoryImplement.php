<?php

namespace App\Repositories\ProcurementItem;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\ProcurementItem;

class ProcurementItemRepositoryImplement extends Eloquent implements ProcurementItemRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(ProcurementItem $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)

    public function deleteByProcurementId(int $procurementId)
    {
        return $this->model->where('procurement_id', $procurementId)->delete();
    }
}
