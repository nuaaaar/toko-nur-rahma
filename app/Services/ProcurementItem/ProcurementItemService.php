<?php

namespace App\Services\ProcurementItem;

use LaravelEasyRepository\BaseService;

interface ProcurementItemService extends BaseService{

    // Write something awesome :)

    public function insertProcurementItems(array $items, int $procurementId);

    public function updateProcurementItems(array $items, int $procurementId);
}
