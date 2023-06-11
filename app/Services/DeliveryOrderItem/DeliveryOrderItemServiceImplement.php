<?php

namespace App\Services\DeliveryOrderItem;

use LaravelEasyRepository\Service;
use App\Repositories\DeliveryOrderItem\DeliveryOrderItemRepository;

class DeliveryOrderItemServiceImplement extends Service implements DeliveryOrderItemService{

     /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
     protected $mainRepository;

    public function __construct(DeliveryOrderItemRepository $mainRepository)
    {
      $this->mainRepository = $mainRepository;
    }

    // Define your custom methods :)

    public function insertDeliveryOrderItems(array $items, int $deliveryOrder)
    {
        $items = array_map(function($item) use ($deliveryOrder){
            $item['delivery_order_id'] = $deliveryOrder;
            $item['created_at'] = now();
            $item['updated_at'] = now();

            return $item;
        }, $items);

        return $this->mainRepository->insert($items);
    }

    public function updateDeliveryOrderItems(array $items, int $deliveryOrderId)
    {
        $this->mainRepository->deleteByDeliveryOrderId($deliveryOrderId);

        return $this->insertDeliveryOrderItems($items, $deliveryOrderId);
    }
}
