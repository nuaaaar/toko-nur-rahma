<?php

namespace App\Services\SaleItem;

use LaravelEasyRepository\Service;
use App\Repositories\SaleItem\SaleItemRepository;

class SaleItemServiceImplement extends Service implements SaleItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(SaleItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertSaleItems(array $items, int $saleId)
    {
        $items = array_map(function($item) use ($saleId){
            $item['sale_id'] = $saleId;
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updateSaleItems(array $items, int $saleId)
    {
        $this->mainRepository->deleteBySaleId($saleId);

        return $this->insertSaleItems($items, $saleId);
    }
}
