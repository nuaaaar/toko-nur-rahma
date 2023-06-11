<?php

namespace App\Services\ProcurementItem;

use LaravelEasyRepository\Service;
use App\Repositories\ProcurementItem\ProcurementItemRepository;

class ProcurementItemServiceImplement extends Service implements ProcurementItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(ProcurementItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertProcurementItems(array $items, int $procurementId)
    {
        $items = array_map(function($item) use ($procurementId){
            $item['procurement_id'] = $procurementId;
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updateProcurementItems(array $items, int $procurementId)
    {
        $this->mainRepository->deleteByProcurementId($procurementId);

        return $this->insertProcurementItems($items, $procurementId);
    }
}
