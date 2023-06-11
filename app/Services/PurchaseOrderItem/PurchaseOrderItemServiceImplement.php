<?php

namespace App\Services\PurchaseOrderItem;

use LaravelEasyRepository\Service;
use App\Repositories\PurchaseOrderItem\PurchaseOrderItemRepository;

class PurchaseOrderItemServiceImplement extends Service implements PurchaseOrderItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(PurchaseOrderItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertPurchaseOrderItems(array $items, int $purchaseOrderId)
    {
        $items = array_map(function($item) use ($purchaseOrderId){
            $item['purchase_order_id'] = $purchaseOrderId;
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updatePurchaseOrderItems(array $items, int $purchaseOrderId)
    {
        $this->mainRepository->deleteByPurchaseOrderId($purchaseOrderId);

        return $this->insertPurchaseOrderItems($items, $purchaseOrderId);
    }
}
