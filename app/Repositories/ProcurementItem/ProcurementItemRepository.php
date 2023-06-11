<?php

namespace App\Repositories\ProcurementItem;

use LaravelEasyRepository\Repository;

interface ProcurementItemRepository extends Repository{

    // Write something awesome :)

    public function deleteByProcurementId(int $procurementId);
}
